<?php

namespace App\Service\Subscription;

use App\Entity\Subscription;
use App\Repository\SubscriptionPermissionKeyRepository;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SetPermissionsToSubscriptionService.
 *
 * @package App\Service\Subscription
 *
 * @author  Codememory
 */
class SetPermissionsToSubscriptionService
{
    #[Required]
    public ?SubscriptionPermissionKeyRepository $subscriptionPermissionKeyRepository = null;

    /**
     * @param Subscription $subscription
     * @param array        $permissionKeys
     *
     * @return void
     */
    public function set(Subscription $subscription, array $permissionKeys): void
    {
        $subscriptionPermissionKeys = [];

        foreach ($permissionKeys as $permissionKey) {
            $subscriptionPermissionKey = $this->subscriptionPermissionKeyRepository->findOneBy([
                'key' => $permissionKey
            ]);

            if (null === $subscriptionPermissionKey) {
                throw EntityNotFoundException::subscriptionPermissionKey();
            }

            $subscriptionPermissionKeys[] = $subscriptionPermissionKey;
        }

        $subscription->setPermissions($subscriptionPermissionKeys);
    }
}