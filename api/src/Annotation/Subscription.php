<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\SubscriptionEnum;
use Attribute;

/**
 * Class Subscription.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
class Subscription implements MethodAnnotationInterface
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