<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintAvailabilityHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;
use App\Service\LogicBranches\SubscriptionPermissionBranchHandler;

final class SubscriptionPermissionHandler extends AbstractConstraintHandler implements ConstraintAvailabilityHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser,
        private readonly SubscriptionPermissionBranchHandler $subscriptionPermissionBranchHandler
    ) {
    }

    /**
     * @param SubscriptionPermission $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        $user = $this->authorizedUser->getUser();

        return null !== $user && $this->subscriptionPermissionBranchHandler->allowedPermission($user, $constraint->permission);
    }
}