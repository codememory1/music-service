<?php

namespace App\Dto\Constraints;

use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\Dto\Interfaces\DataTransferConstraintInterface;
use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class AllowedCallSetterBySubscriptionPermissionConstraint implements DataTransferConstraintInterface
{
    public function __construct(
        public readonly SubscriptionPermissionEnum $permission
    ) {
    }

    public function getHandler(): ?string
    {
        return AllowedCallSetterBySubscriptionPermissionConstraintHandler::class;
    }
}