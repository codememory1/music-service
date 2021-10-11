<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\RoleEntity;
use App\Orm\Entities\SubscriptionEntity;
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

        $this->addReferences($result);

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

        $this->addReferences($result);

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

    /**
     * @param UserEntity[] $users
     *
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    private function addReferences(array &$users): void
    {

        /** @var SubscriptionRepository $subscriptionRepository */
        $subscriptionRepository = $this->getRepository(SubscriptionEntity::class);

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(RoleEntity::class);

        foreach ($users as &$userEntity) {
            $subscriptionId = $userEntity->getSubscription();

            // Check if the user has a subscription
            if (null !== $subscriptionId) {
                $subscriptionData = $subscriptionRepository->findOneWithOptionsAsEntity($userEntity->getSubscription());

                $userEntity->setSubscriptionData($subscriptionData);
            }

            $userEntity->setRoleData($roleRepository->findOne($userEntity->getRole()));
        }

    }

}