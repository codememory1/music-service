<?php

namespace App\ResponseData\Constraints;

use App\Enum\SubscriptionEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

/**
 * Class Subscription.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class Subscription implements ConstraintInterface
{
    public readonly SubscriptionEnum $subscription;

    public function __construct(SubscriptionEnum $subscriptionEnum)
    {
        $this->subscription = $subscriptionEnum;
    }

    public function getHandler(): string
    {
        return SubscriptionHandler::class;
    }
}