<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionOptionEntity;
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
        $this->push($subscriptionOptionRepository, $options, $subscriptionId);

    }

    /**
     * @param SubscriptionOptionRepository $subscriptionOptionRepository
     * @param array                        $options
     * @param int                          $id
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function push(SubscriptionOptionRepository $subscriptionOptionRepository, array $options, int $id): void
    {

        $subscriptionOptionEntity = new SubscriptionOptionEntity();

        // Commit all subscription options
        foreach ($options as $option) {
            if (!$subscriptionOptionRepository->exist(['subscription_option_name_id' => $option])) {
                $subscriptionOptionEntity
                    ->setOption($option)
                    ->setSubscription($id);

                $this->getEntityManager()->commit($subscriptionOptionEntity);
            }
        }

        $this->getEntityManager()->flush();

    }

}