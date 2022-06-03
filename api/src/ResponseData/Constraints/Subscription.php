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
    /**
     * @var SubscriptionEnum
     */
    public readonly SubscriptionEnum $subscription;

    /**
     * @param SubscriptionEnum $subscriptionEnum
     */
    public function __construct(SubscriptionEnum $subscriptionEnum)
    {
        $this->subscription = $subscriptionEnum;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return SubscriptionHandler::class;
    }
}