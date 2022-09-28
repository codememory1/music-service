<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Enum\SubscriptionEnum;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class Subscription implements ConstraintInterface
{
    public readonly SubscriptionEnum $subscription;

    public function __construct(SubscriptionEnum $subscription)
    {
        $this->subscription = $subscription;
    }

    public function getHandler(): string
    {
        return SubscriptionHandler::class;
    }
}