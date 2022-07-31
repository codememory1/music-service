<?php

namespace App\Service\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class CreateSubscriptionService extends AbstractService
{
    public function create(SubscriptionDto $subscriptionDto): Subscription
    {
        $this->validate($subscriptionDto);

        $subscription = $subscriptionDto->getEntity();

        $this->flusherService->save($subscription);

        return $subscription;
    }

    public function request(SubscriptionDto $subscriptionDto): JsonResponse
    {
        $this->create($subscriptionDto);

        return $this->responseCollection->successCreate('subscription@successCreate');
    }
}