<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\Auth\AuthorizedUser;

/**
 * Class UserRolePermissionHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class UserRolePermissionHandler implements MethodAnnotationHandlerInterface
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
     * @param MethodAnnotationInterface|UserRolePermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (false === $this->authorizedUser->hasRolePermission($annotation->rolePermission)) {
            throw AccessDeniedException::notEnoughPermissions();
        }
    }
}