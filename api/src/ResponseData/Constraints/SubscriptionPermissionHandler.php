<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;

/**
 * Class SubscriptionPermissionHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class SubscriptionPermissionHandler implements ConstraintHandlerInterface
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
     * @param SubscriptionPermission $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $this->authorizedUser->isSubscriptionPermission($constraint->permission);
    }
}