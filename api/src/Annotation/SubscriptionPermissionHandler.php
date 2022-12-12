<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AccessDeniedException;
use App\Security\AuthorizedUser;
use App\Service\Subscription\Permission\AllowedSubscriptionPermission;

final class SubscriptionPermissionHandler implements MethodAnnotationHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser,
        private readonly AllowedSubscriptionPermission $allowedSubscriptionPermission
    ) {
    }

    /**
     * @param SubscriptionPermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        $user = $this->authorizedUser->getUser();

        if (null === $user->getSubscription() || !$this->allowedSubscriptionPermission->isFullAllowedPermission($user, $annotation->subscriptionPermission)) {
            throw AccessDeniedException::notEnoughSubscriptionPermissions();
        }
    }
}