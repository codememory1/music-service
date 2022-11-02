<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Exception\Http\AccessDeniedException;
use App\Security\AuthorizedUser;

final class SubscriptionHandler implements MethodAnnotationHandlerInterface
{
    public function __construct(
        private readonly AuthorizedUser $authorizedUser
    ) {}

    /**
     * @param Subscription $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        if (true !== $this->authorizedUser->getUser()?->isSubscription($annotation->subscription)) {
            throw AccessDeniedException::notSubscription();
        }
    }
}