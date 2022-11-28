<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AccessDeniedException;
use App\Security\AuthorizedUser;
use App\Service\LogicBranches\SubscriptionPermissionBranchHandler;

final class SubscriptionPermissionHandler implements MethodAnnotationHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser,
        private readonly SubscriptionPermissionBranchHandler $subscriptionPermissionBranchHandler
    ) {
    }

    /**
     * @param SubscriptionPermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (!$this->isHasPermission($annotation) || !$this->isAllowedPermission($annotation)) {
            throw AccessDeniedException::notEnoughSubscriptionPermissions();
        }
    }

    private function isHasPermission(SubscriptionPermission $annotation): bool
    {
        return true === $this->authorizedUser->getUser()?->isSubscriptionPermission($annotation->subscriptionPermission);
    }

    private function isAllowedPermission(SubscriptionPermission $annotation): bool
    {
        return $this->subscriptionPermissionBranchHandler->allowedPermission($annotation->subscriptionPermission);
    }
}