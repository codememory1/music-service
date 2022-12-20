<?php

namespace App\Dto\Constraints;

use App\Infrastructure\Dto\AbstractDataTransferCallSetterConstraintHandler;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use App\Security\AuthorizedUser;
use App\Service\LogicBranches\SubscriptionPermissionBranchHandler;

final class AllowedCallSetterBySubscriptionPermissionConstraintHandler extends AbstractDataTransferCallSetterConstraintHandler
{
    public function __construct(
        private readonly SubscriptionPermissionBranchHandler $subscriptionPermissionBranchHandler,
        private readonly AuthorizedUser $authorizedUser
    ) {
    }

    /**
     * @param AllowedCallSetterBySubscriptionPermissionConstraint $constraint
     */
    public function handle(DataTransferConstraintInterface $constraint): bool
    {
        $this->authorizedUser->fromBearer();

        return $this->subscriptionPermissionBranchHandler->allowedPermission(
            $this->authorizedUser->getUser(),
            $constraint->permission
        );
    }
}