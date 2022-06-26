<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\AuthorizedUser;

/**
 * Class SubscriptionPermissionHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class SubscriptionPermissionHandler implements MethodAnnotationHandlerInterface
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
     * @param SubscriptionPermission $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (true !== $this->authorizedUser->isSubscriptionPermission($annotation->permission)) {
            throw AccessDeniedException::notEnoughSubscriptionPermissions();
        }
    }
}