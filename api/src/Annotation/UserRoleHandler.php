<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\AuthorizedUser;

final class UserRoleHandler implements MethodAnnotationHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
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