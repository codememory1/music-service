<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionOptionEntity;
use App\Orm\Entities\SubscriptionOptionNameEntity;
use App\Orm\Repositories\SubscriptionOptionNameRepository;
use App\Orm\Repositories\SubscriptionOptionRepository;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Codememory\Components\Services\AbstractService;
use ReflectionException;

/**
 * Class UpdateSubscriptionOptionsService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class UpdateSubscriptionOptionsService extends AbstractService
{

    /**
     * @param array $options
     * @param int   $subscriptionId
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    public function make(array $options, int $subscriptionId): void
    {

        /** @var SubscriptionOptionRepository $subscriptionOptionRepository */
        $subscriptionOptionRepository = $this->getRepository(SubscriptionOptionEntity::class);

        // Removing all subscription options
        $subscriptionOptionRepository->delete(['subscription_id' => $subscriptionId]);

        // Pushing updated subscription options
        $this->push($options, $subscriptionId);

    }

    /**
     * @param array $options
     * @param int   $id
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function push( array $options, int $id): void
    {

        /** @var SubscriptionOptionNameRepository $subscriptionOptionNameRepository */
        $subscriptionOptionNameRepository = $this->getRepository(SubscriptionOptionNameEntity::class);
        $subscriptionOptionEntity = new SubscriptionOptionEntity();

        // Commit all subscription options
        foreach ($options as $option) {
            $option = (int) $option;

            if (false !== $subscriptionOptionNameRepository->findById($option) && 0 !== $option) {
                $subscriptionOptionEntity
                    ->setOption($option)
                    ->setSubscription($id);

                $this->getEntityManager()->commit($subscriptionOptionEntity);
            }
        }

        $this->getEntityManager()->flush();

    }

}