<?php

namespace App\ResponseData\Constraints;

use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class SubscriptionPermission implements ConstraintInterface
{
    public readonly SubscriptionPermissionEnum $permission;

    public function __construct(SubscriptionPermissionEnum $subscriptionPermissionEnum)
    {
        $this->permission = $subscriptionPermissionEnum;
    }

    public function getHandler(): string
    {
        return SubscriptionPermissionHandler::class;
    }
}