<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\AuthorizedUser;

/**
 * Class UserRolePermissionHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class UserRolePermissionHandler implements MethodAnnotationHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @inheritDoc
     *
     * @param MethodAnnotationInterface|UserRolePermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (false === $this->authorizedUser->isRolePermission($annotation->rolePermission)) {
            throw AccessDeniedException::notEnoughPermissions();
        }
    }
}