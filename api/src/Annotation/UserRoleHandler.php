<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\Auth\AuthorizedUser;

/**
 * Class UserRoleHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class UserRoleHandler implements MethodAnnotationHandlerInterface
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
     * @param MethodAnnotationInterface|UserRole $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (false === $this->authorizedUser->hasRole($annotation->role)) {
            throw AccessDeniedException::notEnoughPermissions();
        }
    }
}