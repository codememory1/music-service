<?php

namespace App\Services\Subscription;

use App\Orm\Entities\SubscriptionOptionEntity;
use App\Orm\Repositories\SubscriptionOptionRepository;
use App\Services\AbstractApiService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use Illuminate\Support\Collection;
use ReflectionException;

/**
 * Class UpdateSubscriptionOptionsService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class UpdateSubscriptionOptionsService extends AbstractApiService
{

    /**
     * @param Collection $options
     * @param int        $subscriptionId
     *
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function update(Collection $options, int $subscriptionId): void
    {

        /** @var SubscriptionOptionRepository $subscriptionOptionRepository */
        $subscriptionOptionRepository = $this->getRepository(SubscriptionOptionEntity::class);

        // Removing all subscription options
        $subscriptionOptionRepository->delete(['subscription' => $subscriptionId]);

        // Pushing updated subscription options
        $this->pushOptions($subscriptionOptionRepository, $options, $subscriptionId);

    }

    /**
     * @param SubscriptionOptionRepository $subscriptionOptionRepository
     * @param Collection                   $options
     * @param int                          $id
     *
     * @return void
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    private function pushOptions(SubscriptionOptionRepository $subscriptionOptionRepository, Collection $options, int $id): void
    {

        $subscriptionOptionEntity = new SubscriptionOptionEntity();

        // Commit all subscription options
        foreach ($options->all() as $option) {
            if (!$subscriptionOptionRepository->exist(['option_name_id' => $option])) {
                $subscriptionOptionEntity
                    ->setOption($option)
                    ->setSubscription($id);

                $this->getEntityManager()->commit($subscriptionOptionEntity);
            }
        }

        $this->getEntityManager()->flush();

    }

}