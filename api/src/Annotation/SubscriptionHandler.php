<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\AuthorizedUser;

/**
 * Class SubscriptionHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class SubscriptionHandler implements MethodAnnotationHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @inheritDoc
     *
     * @param Subscription $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (false === $this->authorizedUser->isSubscription($annotation->subscription)) {
            throw AccessDeniedException::notSubscription();
        }
    }
}