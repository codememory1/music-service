<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class DeleteSubscriptionService extends AbstractService
{
    public function delete(Subscription $subscription): Subscription
    {
        $this->flusherService->remove($subscription);

        return $subscription;
    }

    public function request(Subscription $subscription): JsonResponse
    {
        $this->delete($subscription);

        return $this->responseCollection->successDelete('subscription@successDelete');
    }
}