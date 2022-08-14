<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;

final class SubscriptionPermissionHandler implements ConstraintHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @param ConstraintInterface|SubscriptionPermission $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        $user = $this->authorizedUser->getUser();

        if (null === $user) {
            return false;
        }

        return $user->isSubscriptionPermission($constraint->permission);
    }
}