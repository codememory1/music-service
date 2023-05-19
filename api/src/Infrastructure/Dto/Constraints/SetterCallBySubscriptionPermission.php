<?php

namespace App\Infrastructure\Dto\Constraints;

use App\Enum\SubscriptionPermissionEnum;
use Attribute;
use Codememory\Dto\Interfaces\ConstraintInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
final class SetterCallBySubscriptionPermission implements ConstraintInterface
{
    public function __construct(
        public readonly SubscriptionPermissionEnum $permission,
        public readonly bool $useDefaultValue = false
    ) {
    }

    public function getHandler(): string
    {
        return SetterCallBySubscriptionPermissionHandler::class;
    }
}