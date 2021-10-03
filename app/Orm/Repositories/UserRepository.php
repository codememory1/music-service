<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\UserEntity;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
use ReflectionException;

/**
 * Class UserRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class UserRepository extends AbstractEntityRepository
{

    /**
     * @param array $by
     *
     * @return bool|UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOne(array $by): bool|UserEntity
    {

        $result = $this->findBy($by)->toEntity();

        return [] !== $result ? $result[0] : false;

    }

    /**
     * @param array $by
     *
     * @return bool|UserEntity
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOneByOr(array $by): bool|UserEntity
    {

        $result = $this->findBy($by, 'or')->toEntity();

        return [] !== $result ? $result[0] : false;

    }

    /**
     * @param array  $data
     * @param string $email
     *
     * @return void
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function updateUser(array $data, string $email): void
    {

        $this->update($data, ['email' => $email]);

    }

}