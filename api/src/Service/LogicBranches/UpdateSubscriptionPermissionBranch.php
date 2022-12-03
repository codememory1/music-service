<?php

namespace App\Service\LogicBranches;

use App\Dto\Transfer\SubscriptionPermissionBranchDto;
use App\Entity\SubscriptionPermissionBranch;
use App\Infrastructure\Validator\Validator;
use App\Repository\SubscriptionPermissionBranchRepository;
use Doctrine\ORM\EntityManagerInterface;

final class UpdateSubscriptionPermissionBranch
{
    public function __construct(
        private readonly Validator $validator,
        private readonly EntityManagerInterface $em,
        private readonly SubscriptionPermissionBranchRepository $subscriptionPermissionBranchRepository
    ) {
    }

    public function update(SubscriptionPermissionBranchDto $dto): void
    {
        $this->validator->validate($dto);

        $this->updateIgnoredPermissions($dto->ignoredPermissions);

        $this->em->flush();
    }

    public function updateIgnoredPermissions(array $permissions): SubscriptionPermissionBranch
    {
        $ignoredPermission = $this->subscriptionPermissionBranchRepository->findByKey(SubscriptionPermissionBranch::IGNORED_PERMISSIONS_KEY);

        $ignoredPermission->setValue($permissions);

        return $ignoredPermission;
    }
}