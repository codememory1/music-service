<?php

namespace App\Service\Subscription\Permission;

use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Service\LogicBranches\SubscriptionPermissionBranchHandler;

final class AllowedSubscriptionPermission
{
    public function __construct(
        private readonly SubscriptionPermissionBranchHandler $subscriptionPermissionBranchHandler
    ) {
    }

    public function isFullAllowedPermission(User $user, SubscriptionPermissionEnum $subscriptionPermission): bool
    {
        return !$this->subscriptionPermissionBranchHandler->allowedPermission($subscriptionPermission)
            || $user->isSubscriptionPermission($subscriptionPermission);
    }

    public function isMaxPlaylists(User $user): bool
    {
        if (!$this->subscriptionPermissionBranchHandler->allowedPermission(SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY)) {
            return false;
        }

        if ($user->isSubscriptionPermission(SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY)) {
            $subscriptionPermission = $user
                ->getSubscription()
                ->getPermission(SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY);

            return $user->getMediaLibrary()?->getPlaylists()->count() >= $subscriptionPermission->getValue(true);
        }

        return true;
    }
}