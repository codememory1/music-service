<?php

namespace App\AnnotationListener;

use App\Rest\ClassHelper\AttributeData;

/**
 * Class UserRolePermissionAnnotationListener.
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
class UserRolePermissionAnnotationListener extends AbstractAnnotationListener
{
    /**
     * @inheritDoc
     */
    public function listen(AttributeData $attributeData): void
    {
        $user = $this->authenticator->getUser();

        if (null === $user || $user->getRole()->getRolePermissions()->contains($attributeData->permission)) {
            $this->responseCollection->accessIsDenied();

            $this->response();
        }
    }
}