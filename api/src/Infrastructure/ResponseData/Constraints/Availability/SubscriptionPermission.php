<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class SubscriptionPermission implements ConstraintInterface
{
    public readonly SubscriptionPermissionEnum $permission;

    public function __construct(SubscriptionPermissionEnum $subscriptionPermission)
    {
        $this->permission = $subscriptionPermission;
    }

    public function getHandler(): string
    {
        return SubscriptionPermissionHandler::class;
    }
}