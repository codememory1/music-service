<?php

namespace App\Service\Subscription;

use App\Dto\Transfer\SubscriptionDto;
use App\Entity\Subscription;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class UpdateSubscriptionService extends AbstractService
{
    public function update(SubscriptionDto $subscriptionDto): Subscription
    {
        $this->validate($subscriptionDto);

        $this->flusherService->save();

        return $subscriptionDto->getEntity();
    }

    public function request(SubscriptionDto $subscriptionDto): JsonResponse
    {
        $this->update($subscriptionDto);

        return $this->responseCollection->successUpdate('subscription@successUpdate');
    }
}