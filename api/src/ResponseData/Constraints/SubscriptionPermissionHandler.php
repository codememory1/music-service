<?php

namespace App\ResponseData\Constraints;

use App\Entity\SubscriptionPermission as SubscriptionPermissionEntity;
use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\Auth\AuthorizedUser;

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
        $user = $this->authorizedUser->getUser();
        $subscriptionPermissions = $user?->getSubscription()?->getPermissions();

        return $subscriptionPermissions?->exists(static fn(int $key, SubscriptionPermissionEntity $subscriptionPermission) => $subscriptionPermission->getPermissionKey()->getKey() === $constraint->permission->name) ?? false;
    }
}