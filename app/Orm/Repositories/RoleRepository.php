<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\RoleEntity;
use App\Orm\Entities\RoleRightEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class RoleRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class RoleRepository extends AbstractEntityRepository
{

    public const USER_ROLE = 'User';
    public const ADMIN_ROLE = 'Administrator';
    public const DEV_ROLE = 'Developer';
    public const MUSIC_MANAGER_ROLE = 'Music manager';
    public const SUPPORT_ROLE = 'Support';

    /**
     * @param string $name
     *
     * @return bool|int
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function getIdByName(string $name): bool|int
    {

        $result = $this->customFindBy(['name' => $name])->array()->first();

        return $result['id'] ?? false;

    }

    /**
     * @param int $id
     *
     * @return bool|RoleEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(int $id): bool|RoleEntity
    {

        /** @var RoleEntity|false $result */
        $role = $this->customFindBy(['id' => $id])->entity()->first();

        if ($role instanceof RoleEntity) {
            /** @var RoleRightRepository $roleRightRepository */
            $roleRightRepository = $this->getRepository(RoleRightEntity::class);

            $role->setRights($roleRightRepository->findAllWithNames($role->getId()));

            return $role;
        }

        return false;

    }

}