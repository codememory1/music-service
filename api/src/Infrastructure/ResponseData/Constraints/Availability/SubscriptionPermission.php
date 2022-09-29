<?php

namespace App\Infrastructure\ResponseData\Constraints\Availability;

use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class SubscriptionPermission implements ConstraintInterface
{
    public function __construct(
        public readonly SubscriptionPermissionEnum $permission
    ) {
    }

    public function getHandler(): string
    {
        return SubscriptionPermissionHandler::class;
    }
}