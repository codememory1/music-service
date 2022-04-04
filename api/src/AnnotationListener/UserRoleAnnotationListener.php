<?php

namespace App\AnnotationListener;

use App\Rest\ClassHelper\AttributeData;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class UserRoleAnnotationListener.
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
class UserRoleAnnotationListener extends AbstractAnnotationListener
{
    /**
     * @param AttributeData $attributeData
     *
     * @return void
     */
    #[NoReturn]
    public function listen(AttributeData $attributeData): void
    {
        $user = $this->authenticator->getUser();

        if (null !== $user && !in_array($user->getRole()->getKey(), $attributeData->keys, true)) {
            $this->responseCollection->accessIsDenied('common@checkRole');

            $this->response();
        }
    }
}