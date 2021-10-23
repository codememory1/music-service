<?php

namespace App\Orm\Repositories;

use App\Orm\Dto\SubscriptionDto;
use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Entities\SubscriptionOptionEntity;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class SubscriptionRepository
 *
 * @package App\Orm\Repositories
 *
 * @author  Danil
 */
class SubscriptionRepository extends AbstractRepositoryWithSorting
{

    /**
     * @param array  $sortBy
     * @param string $sortingType
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findAllAsEntity(array $sortBy = [], string $sortingType = 'desc'): array
    {

        $qb = $this->createQueryBuilder();
        $tableName = $this->getEntityData()->getTableName();

        $qb->select()->from($tableName);

        $this->sortingRepository->addSorting($qb, $tableName, $sortBy, $sortingType);

        return $qb->generateTo()->entity()->all();

    }

    /**
     * @param array $by
     *
     * @return SubscriptionEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOne(array $by): SubscriptionEntity|bool
    {

        return $this->customFindBy($by)->entity()->first();

    }

    /**
     * @param int $subscription
     *
     * @return SubscriptionEntity|bool
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOneWithOptionsAsEntity(int $subscription): SubscriptionEntity|bool
    {

        $subscriptionEntity = $this->findOne([
            'id' => $subscription
        ]);

        if (false !== $subscriptionEntity) {
            /** @var SubscriptionOptionRepository $subscriptionOptionsRepository */
            $subscriptionOptionsRepository = $this->getRepository(SubscriptionOptionEntity::class);

            $subscriptionEntity->setOptions($subscriptionOptionsRepository->findBySubscriptionWithName($subscription));

            return $subscriptionEntity;
        }

        return false;

    }

    /**
     * @param int $subscription
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findOneWithOptions(int $subscription): array
    {

        $subscriptionEntity = $this->findOneWithOptionsAsEntity($subscription);

        if (false !== $subscriptionEntity) {
            return (new SubscriptionDto($subscriptionEntity))->getTransformedData();
        }

        return [];

    }

    /**
     * @param array  $sortBy
     * @param string $sortingType
     *
     * @return array
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function findAllWithOptions(array $sortBy = [], string $sortingType = 'desc'): array
    {

        $subscriptions = [];

        /** @var SubscriptionEntity $subscription */
        foreach ($this->findAllAsEntity($sortBy, $sortingType) as $subscription) {
            /** @var SubscriptionOptionRepository $subscriptionOptionsRepository */
            $subscriptionOptionsRepository = $this->getRepository(SubscriptionOptionEntity::class);

            $subscription->setOptions($subscriptionOptionsRepository->findBySubscriptionWithName($subscription->getId()));

            $subscriptions[] = (new SubscriptionDto($subscription))->getTransformedData();
        }

        return $subscriptions;

    }

    /**
     * @param int $id
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function deleteById(int $id): void
    {

        /** @var SubscriptionOptionRepository $subscriptionOptionRepository */
        $subscriptionOptionRepository = $this->getRepository(SubscriptionOptionEntity::class);

        $subscriptionOptionRepository->delete([
            'subscription' => $id
        ]);

        $this->delete(['id' => $id]);

    }

}