<?php

namespace App\Service\LogicBranches;

use App\Entity\SubscriptionPermissionBranch;
use App\Entity\User;
use App\Enum\LogicBranchEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Repository\LogicBranchRepository;
use App\Repository\SubscriptionPermissionBranchRepository;

final class SubscriptionPermissionBranchHandler
{
    public function __construct(
        private readonly LogicBranchRepository $logicBranchRepository,
        private readonly SubscriptionPermissionBranchRepository $subscriptionPermissionBranchRepository
    ) {
    }

    public function allowedPermission(User $user, SubscriptionPermissionEnum $permission): bool
    {
        $logicBranch = $this->logicBranchRepository->findByName(LogicBranchEnum::SUBSCRIPTION_PERMISSION);
        $permissionForCheckIfDisabled = $this->subscriptionPermissionBranchRepository->findByKey(SubscriptionPermissionBranch::CHECK_PERMISSIONS_IF_DISABLED);
        $existInCheckIsDisabled = $permissionForCheckIfDisabled->existInCheckIfDisabled($permission);
        $userHasPermission = $user->isSubscriptionPermission($permission);

        return ($logicBranch->isDisabled() && !$existInCheckIsDisabled)
            || ($logicBranch->isEnabled() && $userHasPermission)
            || ($logicBranch->isDisabled() && $existInCheckIsDisabled && $userHasPermission);
    }
}