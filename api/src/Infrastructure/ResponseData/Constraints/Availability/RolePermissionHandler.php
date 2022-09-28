<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintAvailabilityHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;
use function is_array;

final class RolePermissionHandler extends AbstractConstraintHandler implements ConstraintAvailabilityHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @param RolePermission $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        $user = $this->authorizedUser->getUser();

        if (null === $user) {
            return false;
        }

        if (is_array($constraint->permissions)) {
            foreach ($constraint->permissions as $permission) {
                if ($user->isRolePermission($permission)) {
                    return true;
                }
            }

            return false;
        }

        return $user->isRolePermission($constraint->permissions);
    }
}