<?php

namespace App\AnnotationListener;

use App\Enum\ApiResponseTypeEnum;
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
        if (null === $this->authenticator->getUser()) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_AUTH,
                $this->getTranslation('common@checkAuth')
            );

            $this->response('error', 401);
        }
    }
}