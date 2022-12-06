<?php

namespace App\UseCase\Branch;

use App\Dto\Transfer\SubscriptionPermissionBranchDto;
use App\Entity\SubscriptionPermissionBranch;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Repository\SubscriptionPermissionBranchRepository;

final class UpdateSubscriptionPermissionBranch
{
    public function __construct(
        private readonly Validator $validator,
        private readonly Flusher $flusher,
        private readonly SubscriptionPermissionBranchRepository $subscriptionPermissionBranchRepository
    ) {
    }

    public function process(SubscriptionPermissionBranchDto $dto): void
    {
        $this->validator->validate($dto);

        $this->updateIgnoredPermissions($dto->ignoredPermissions);

        $this->flusher->save();
    }

    public function updateIgnoredPermissions(array $permissions): SubscriptionPermissionBranch
    {
        $ignoredPermission = $this->subscriptionPermissionBranchRepository->findByKey(SubscriptionPermissionBranch::IGNORED_PERMISSIONS_KEY);

        $ignoredPermission->setValue($permissions);

        return $ignoredPermission;
    }
}