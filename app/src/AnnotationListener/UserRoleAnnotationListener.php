<?php

namespace App\AnnotationListener;

use App\Enum\ApiResponseTypeEnum;
use App\Rest\ClassHelper\AttributeData;
use JetBrains\PhpStorm\NoReturn;
use ReflectionAttribute;

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
     * @param ReflectionAttribute $attribute
     *
     * @return void
     */
    #[NoReturn]
    public function listen(AttributeData $attributeData): void
    {
        $user = $this->authenticator->getUser();

        if (null !== $user && !in_array($user->getRole()->getKey(), $attributeData->keys, true)) {
            $this->apiResponseSchema->setMessage(
                ApiResponseTypeEnum::CHECK_ROLE,
                $this->getTranslation('common@checkRole')
            );

            $this->response('error', 403);
        }
    }
}