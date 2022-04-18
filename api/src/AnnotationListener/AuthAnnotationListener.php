<?php

namespace App\AnnotationListener;

use App\Rest\ClassHelper\AttributeData;

/**
 * Class AuthAnnotationListener.
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
class AuthAnnotationListener extends AbstractAnnotationListener
{
    /**
     * @inheritDoc
     */
    public function listen(AttributeData $attributeData): void
    {
        if (null === $this->authenticator->getAuthorizedUser()) {
            $this->responseCollection->notAuth();

            $this->response();
        }
    }
}