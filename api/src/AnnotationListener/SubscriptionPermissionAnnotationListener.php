<?php

namespace App\AnnotationListener;

use App\Enum\ApiResponseTypeEnum;
use App\Rest\ClassHelper\AttributeData;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class SubscriptionPermissionAnnotationListener.
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
class SubscriptionPermissionAnnotationListener extends AbstractAnnotationListener
{
    /**
     * @inheritDoc
     */
    public function listen(AttributeData $attributeData): void
    {
        $user = $this->authenticator->getUser();

        if (null === $user || null === $user->getUserSubscription()) {
            $this->responseForbidden();
        } else {
            $subscription = $user->getUserSubscription()->getSubscription();

            if (!$subscription->getPermissions()->contains($attributeData->permission)) {
                $this->responseForbidden();
            }
        }
    }

    /**
     * @return void
     */
    #[NoReturn]
    private function responseForbidden(): void
    {
        $this->apiResponseSchema->setMessage(
            ApiResponseTypeEnum::CHECK_SUBSCRIPTION_PERMISSION,
            $this->getTranslation('common@accessDenied')
        );

        $this->response('error', 403);
    }
}