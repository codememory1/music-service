<?php

namespace App\ResponseData\Constraints;

use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\Interfaces\ConstraintInterface;
use Attribute;

/**
 * Class SubscriptionPermission.
 *
 * @package App\ResponseData\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class SubscriptionPermission implements ConstraintInterface
{
    /**
     * @var SubscriptionPermissionEnum
     */
    public readonly SubscriptionPermissionEnum $permission;

    /**
     * @param SubscriptionPermissionEnum $subscriptionPermissionEnum
     */
    public function __construct(SubscriptionPermissionEnum $subscriptionPermissionEnum)
    {
        $this->permission = $subscriptionPermissionEnum;
    }

    /**
     * @inheritDoc
     */
    public function getHandler(): string
    {
        return SubscriptionPermissionHandler::class;
    }
}