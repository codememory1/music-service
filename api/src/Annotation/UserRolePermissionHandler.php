<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AccessDeniedException;
use App\Security\AuthorizedUser;

final class UserRolePermissionHandler implements MethodAnnotationHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser
    ) {
    }

    /**
     * @param MethodAnnotationInterface|UserRolePermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (true !== $this->authorizedUser->getUser()?->isRolePermission($annotation->rolePermission)) {
            throw AccessDeniedException::notEnoughPermissions();
        }
    }
}