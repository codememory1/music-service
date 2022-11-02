<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AccessDeniedException;
use App\Security\AuthorizedUser;

final class UserRoleHandler implements MethodAnnotationHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser
    ) {
    }

    /**
     * @param MethodAnnotationInterface|UserRole $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (true !== $this->authorizedUser->getUser()?->isRole($annotation->role)) {
            throw AccessDeniedException::notEnoughPermissions();
        }
    }
}