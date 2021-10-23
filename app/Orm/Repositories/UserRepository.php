<?php

namespace App\Orm\Repositories;

use App\Orm\Entities\RoleEntity;
use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Entities\UserEntity;
use Codememory\Components\Database\Orm\Interfaces\EntityDataInterface;
use Codememory\Components\Database\Orm\Interfaces\EntityManagerInterface;
use Codememory\Components\Database\Orm\QueryBuilder\ExtendedQueryBuilder;
use Codememory\Components\Database\Orm\Repository\AbstractEntityRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
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
     * @var SubscriptionRepository
     */
    private SubscriptionRepository $subscriptionRepository;

    /**
     * @var RoleRepository
     */
    private RoleRepository $roleRepository;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ExtendedQueryBuilder   $queryBuilder
     * @param EntityDataInterface    $entityData
     */
    public function __construct(EntityManagerInterface $entityManager, ExtendedQueryBuilder $queryBuilder, EntityDataInterface $entityData)
    {

        parent::__construct($entityManager, $queryBuilder, $entityData);

        /** @var SubscriptionRepository $subscriptionRepository */
        $subscriptionRepository = $this->getRepository(SubscriptionEntity::class);
        $this->subscriptionRepository = $subscriptionRepository;

        /** @var RoleRepository $roleRepository */
        $roleRepository = $this->getRepository(RoleEntity::class);
        $this->roleRepository = $roleRepository;

    }

    /**
     * @param array $by
     *
     * @return bool|UserEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(array $by): bool|UserEntity
    {

        /** @var bool|UserEntity $user */
        $user = $this->customFindBy($by)->entity()->first();

        if (false !== $user) {
            $this->addReference($user);
        }

        return $user;

    }

    /**
     * @param array $by
     *
     * @return bool|UserEntity
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOneByOr(array $by): bool|UserEntity
    {

        $result = $this->customFindBy($by, 'or')->entity()->all();

        $this->addReferences($result);

        return $result[0];

    }

    /**
     * @param array  $data
     * @param string $email
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function updateUser(array $data, string $email): void
    {

        $this->update($data, ['email' => $email]);

    }

    /**
     * @param UserEntity[] $users
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function addReferences(array &$users): void
    {

        foreach ($users as &$userEntity) {
            $this->addReference($userEntity);
        }

    }

    /**
     * @param UserEntity $userEntity
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function addReference(UserEntity &$userEntity): void
    {

        $subscriptionId = $userEntity->getSubscription();

        // Check if the user has a subscription
        if (null !== $subscriptionId) {
            $subscriptionData = $this->subscriptionRepository->findOneWithOptionsAsEntity($userEntity->getSubscription());

            $userEntity->setSubscriptionData($subscriptionData);
        }

        $userEntity->setRoleData($this->roleRepository->findOne($userEntity->getRole()));

    }

}