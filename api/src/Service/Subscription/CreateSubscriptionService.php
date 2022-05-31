<?php

namespace App\Service\Subscription;

use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Entity\SubscriptionPermission;
use App\Repository\SubscriptionPermissionKeyRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
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
    public ?SubscriptionPermissionKeyRepository $subscriptionPermissionKeyRepository = null;

    /**
     * @param SubscriptionDTO $subscriptionDTO
     *
     * @return JsonResponse
     */
    public function make(SubscriptionDTO $subscriptionDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($subscriptionDTO)) {
            return $response;
        }
        
        $subscriptionEntity = $subscriptionDTO->getEntity();

        $this->addPermission($subscriptionEntity, $subscriptionDTO->permissions);

        $this->em->persist($subscriptionEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('subscription@successCreate');
    }

    /**
     * @param Subscription $subscription
     * @param array        $permissionKeys
     *
     * @return void
     */
    public function addPermission(Subscription $subscription, array $permissionKeys): void
    {
        foreach ($permissionKeys as $permissionKey) {
            $subscriptionPermissionKey = $this->subscriptionPermissionKeyRepository->findOneBy([
                'key' => $permissionKey
            ]);

            if (null === $subscriptionPermissionKey) {
                throw EntityNotFoundException::subscriptionPermissionKey();
            }

            $subscriptionPermission = new SubscriptionPermission();

            $subscriptionPermission->setSubscription($subscription);
            $subscriptionPermission->setSubscriptionPermissionKey($subscriptionPermissionKey);

            $subscription->addPermission($subscriptionPermission);
        }
    }
}