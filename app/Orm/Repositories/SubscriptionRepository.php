<?php

namespace App\Orm\Repositories;

use App\Orm\Dto\SubscriptionDto;
use App\Orm\Entities\SubscriptionEntity;
use App\Orm\Entities\SubscriptionOptionEntity;
use Codememory\Components\Database\QueryBuilder\Exceptions\NotSelectedStatementException;
use Codememory\Components\Database\QueryBuilder\Exceptions\QueryNotGeneratedException;
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findAllAsEntity(array $sortBy = [], string $sortingType = 'desc'): array
    {

        $qb = $this->createQueryBuilder();
        $tableName = $this->getEntityData()->getTableName();
        $statement = $qb->select()->from($tableName);

        $this->sortingRepository->addSorting($statement, $tableName, $sortBy, $sortingType);

        return $qb->generateQuery()->toEntity();

    }

    /**
     * @param array $by
     *
     * @return SubscriptionEntity|bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
     */
    public function findOne(array $by): SubscriptionEntity|bool
    {

        $result = $this->findBy($by)->toEntity();

        return [] !== $result ? $result[0] : false;

    }

    /**
     * @param int $subscription
     *
     * @return SubscriptionEntity|bool
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
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
     * @throws NotSelectedStatementException
     * @throws QueryNotGeneratedException
     * @throws ReflectionException
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