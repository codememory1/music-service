<?php

namespace App\AnnotationListener;

use App\Rest\ClassHelper\AttributeData;

/**
 * Class SubscriptionAnnotationListener.
 *
 * @package App\AnnotationListener
 *
 * @author  Codememory
 */
class SubscriptionAnnotationListener extends AbstractAnnotationListener
{
    /**
     * @inheritDoc
     */
    public function listen(AttributeData $attributeData): void
    {
        $user = $this->authenticator->getUser();

        if (null === $user
            || null === $user->getUserSubscription()
            || $user->getUserSubscription()->getSubscription()->getKey() !== $attributeData->key
        ) {
            $this->responseCollection->accessIsDenied('common@invalidSubscription');

            $this->response();
        }
    }
}