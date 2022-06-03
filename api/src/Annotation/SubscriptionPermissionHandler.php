<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Entity\SubscriptionPermission as SubscriptionPermissionEntity;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\Auth\AuthorizedUser;

/**
 * Class SubscriptionPermissionHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class SubscriptionPermissionHandler implements MethodAnnotationHandlerInterface
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
     * @param SubscriptionPermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        $user = $this->authorizedUser->getUser();
        $subscriptionPermissions = $user?->getSubscription()->getPermissions();
        $exist = $subscriptionPermissions?->exists(static fn(int $key, SubscriptionPermissionEntity $subscriptionPermission) => $subscriptionPermission->getPermissionKey()->getKey() === $annotation->permission->name);

        if (true !== $exist) {
            throw AccessDeniedException::notEnoughSubscriptionPermissions();
        }
    }
}