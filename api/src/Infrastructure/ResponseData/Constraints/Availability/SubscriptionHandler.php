<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Infrastructure\ResponseData\Constraints\AbstractConstraintHandler;
use App\Infrastructure\ResponseData\Interfaces\ConstraintAvailabilityHandlerInterface;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;

final class SubscriptionHandler extends AbstractConstraintHandler implements ConstraintAvailabilityHandlerInterface
{
    public function __construct(
        private AuthorizedUser $authorizedUser
    ) {
    }

    /**
     * @param Subscription $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        $user = $this->authorizedUser->getUser();

        if (null === $user) {
            return false;
        }

        return $user->isSubscription($constraint->subscription);
    }
}