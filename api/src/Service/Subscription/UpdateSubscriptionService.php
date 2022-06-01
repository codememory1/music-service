<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class UpdateSubscriptionService extends AbstractService
{
    #[Required]
    public ?SetPermissionsToSubscriptionService $setPermissionsToSubscriptionService = null;

    /**
     * @param SubscriptionDTO $subscriptionDTO
     * @param Subscription    $subscription
     *
     * @return JsonResponse
     */
    public function make(SubscriptionDTO $subscriptionDTO, Subscription $subscription): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($subscriptionDTO)) {
            return $response;
        }

        $this->setPermissionsToSubscriptionService->set($subscription, $subscriptionDTO->permissions);

        $this->em->flush();

        return $this->responseCollection->successUpdate('subscription@successUpdate');
    }
}