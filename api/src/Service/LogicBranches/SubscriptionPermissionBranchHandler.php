<?php

namespace App\Service\LogicBranches;

use App\Entity\SubscriptionPermissionBranch;
use App\Enum\LogicBranchEnum;
use App\Enum\LogicBranchStatusEnum;
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

    public function allowedPermission(SubscriptionPermissionEnum $permission): bool
    {
        $logicBranch = $this->logicBranchRepository->findByName(LogicBranchEnum::SUBSCRIPTION_PERMISSION);
        $ignoredPermissions = $this->subscriptionPermissionBranchRepository->findByKey(SubscriptionPermissionBranch::IGNORED_PERMISSIONS_KEY);

        return $logicBranch->getStatus() === LogicBranchStatusEnum::ENABLED->name
            && false === in_array($permission->name, $ignoredPermissions->getValue(), true);
    }
}