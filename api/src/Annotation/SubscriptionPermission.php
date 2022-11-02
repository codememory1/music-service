<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\SubscriptionPermissionEnum;
use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::TARGET_CLASS)]
final class SubscriptionPermission implements MethodAnnotationInterface
{
    public function __construct(
        public readonly SubscriptionPermissionEnum $subscriptionPermission
    ) {
    }

    public function getHandler(): string
    {
        return SubscriptionPermissionHandler::class;
    }
}