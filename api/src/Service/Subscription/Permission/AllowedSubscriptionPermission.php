<?php

namespace App\Service\Subscription\Permission;

use App\Entity\Playlist;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Service\LogicBranches\SubscriptionPermissionBranchHandler;

final class AllowedSubscriptionPermission
{
    public function __construct(
        private readonly SubscriptionPermissionBranchHandler $subscriptionPermissionBranchHandler
    ) {
    }

    public function isMaxPlaylists(User $user): bool
    {
        if (!$this->subscriptionPermissionBranchHandler->allowedPermission($user, SubscriptionPermissionEnum::MAX_PLAYLISTS_IN_MEDIA_LIBRARY)) {
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

    public function isMaxDirectoriesInPlaylists(Playlist $playlist): bool
    {
        $playlistOwner = $playlist->getMediaLibrary()->getUser();

        if (!$this->subscriptionPermissionBranchHandler->allowedPermission($playlistOwner, SubscriptionPermissionEnum::MAX_DIRECTORIES_IN_PLAYLIST)) {
            return false;
        }

        if ($playlistOwner->isSubscriptionPermission(SubscriptionPermissionEnum::MAX_DIRECTORIES_IN_PLAYLIST)) {
            $subscriptionPermission = $playlistOwner
                ->getSubscription()
                ->getPermission(SubscriptionPermissionEnum::MAX_DIRECTORIES_IN_PLAYLIST);

            return $playlist->getDirectories()->count() >= $subscriptionPermission->getValue(true);
        }

        return true;
    }
}