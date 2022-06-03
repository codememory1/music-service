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
#[Attribute(Attribute::TARGET_METHOD)]
class Subscription implements MethodAnnotationInterface
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