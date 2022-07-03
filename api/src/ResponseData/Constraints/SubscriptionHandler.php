<?php

namespace App\ResponseData\Constraints;

use App\ResponseData\Interfaces\ConstraintHandlerInterface;
use App\ResponseData\Interfaces\ConstraintInterface;
use App\Security\AuthorizedUser;

/**
 * Class SubscriptionHandler.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
class SubscriptionHandler implements ConstraintHandlerInterface
{
    private AuthorizedUser $authorizedUser;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @param ConstraintInterface|Subscription $constraint
     */
    public function handle(ConstraintInterface $constraint): bool
    {
        return $this->authorizedUser->isSubscription($constraint->subscription);
    }
}