<?php

namespace App\Services\Subscription;

use App\Orm\Repositories\SubscriptionRepository;
use App\Services\AbstractApiService;
use App\Services\ResponseApiCollectorService;
use Codememory\Components\Database\QueryBuilder\Exceptions\StatementNotSelectedException;
use ReflectionException;

/**
 * Class RemoverService
 *
 * @package App\Services\Subscription
 *
 * @author  Danil
 */
class RemoverService extends AbstractApiService
{

    /**
     * @param SubscriptionRepository $subscriptionRepository
     * @param int                    $id
     *
     * @return ResponseApiCollectorService
     * @throws ReflectionException
     * @throws StatementNotSelectedException
     */
    final public function delete(SubscriptionRepository $subscriptionRepository, int $id): ResponseApiCollectorService
    {

        $subscription = $subscriptionRepository->findOne(['id' => $id]);

        // Checking the existence of a subscription
        if (false === $subscription) {
            return $this->createApiResponse(404, 'subscription.subscriptionNotExist');
        }

        // Subscription found. Removing the subscription itself and its options
        $subscriptionRepository->deleteById($id);

        return $this->createApiResponse(200, 'subscription.successDelete');

    }

}