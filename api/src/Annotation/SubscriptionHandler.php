<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationHandlerInterface;
use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Rest\Http\Exceptions\AccessDeniedException;
use App\Security\Auth\AuthorizedUser;

/**
 * Class SubscriptionHandler.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
class SubscriptionHandler implements MethodAnnotationHandlerInterface
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
     * @param Subscription $annotation
     */
    public function handle(MethodAnnotationInterface $annotation): void
    {
        $user = $this->authorizedUser->getUser();

        if ($user?->getSubscription()->getKey() !== $annotation->subscription->name) {
            throw AccessDeniedException::notSubscription();
        }
    }
}