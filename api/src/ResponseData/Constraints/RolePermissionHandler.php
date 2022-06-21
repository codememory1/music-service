<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;
use function is_array;

/**
 * Class RolePermissionHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class RolePermissionHandler implements ConstraintHandlerInterface
{
    /**
     * @var AuthorizedUser
     */
    private AuthorizedUser $authorizedUser;

    /**
     * @param AuthorizedUser $authorizedUser
     */
    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @inheritDoc
     *
     * @param ConstraintInterface|RolePermission $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        if (is_array($constraint->permissions)) {
            foreach ($constraint->permissions as $permission) {
                if ($this->authorizedUser->hasRolePermission($permission)) {
                    return true;
                }
            }

            return false;
        }

        return $this->authorizedUser->hasRolePermission($constraint->permissions);
    }
}