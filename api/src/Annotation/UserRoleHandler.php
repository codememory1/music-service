<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\AuthorizedUser;

/**
 * Class UserRoleHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class UserRoleHandler implements MethodAnnotationHandlerInterface
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
        if (false === $this->authorizedUser->isRole($annotation->role)) {
            throw AccessDeniedException::notEnoughPermissions();
        }
    }
}