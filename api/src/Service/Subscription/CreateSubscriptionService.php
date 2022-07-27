<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class CreateSubscriptionService extends AbstractService
{
    #[Required]
    public ?SetPermissionsToSubscriptionService $setPermissionsToSubscriptionService = null;

    public function make(SubscriptionDTO $subscriptionDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($subscriptionDTO)) {
            return $response;
        }

        $subscription = $subscriptionDTO->getEntity();

        $this->setPermissionsToSubscriptionService->set($subscription, $subscriptionDTO->permissions);

        $this->flusherService->save($subscription);

        return $this->responseCollection->successCreate('subscription@successCreate');
    }
}