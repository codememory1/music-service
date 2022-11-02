<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\SubscriptionEnum;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class Subscription implements MethodAnnotationInterface
{
    public function __construct(
        public readonly SubscriptionEnum $subscription
    ) {}

    public function getHandler(): string
    {
        return SubscriptionHandler::class;
    }
}