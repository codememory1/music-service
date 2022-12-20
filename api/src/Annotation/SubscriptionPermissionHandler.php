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
        $user = $this->authorizedUser->getUser();

        if (!$this->subscriptionPermissionBranchHandler->allowedPermission($user, $annotation->subscriptionPermission)) {
            throw AccessDeniedException::notEnoughSubscriptionPermissions();
        }
    }
}