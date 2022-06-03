<?php

namespace App\Annotation;

use App\Annotation\Interfaces\MethodAnnotationInterface;
use App\Enum\SubscriptionPermissionEnum;
use Attribute;

/**
 * Class SubscriptionPermission.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class SubscriptionPermission implements MethodAnnotationInterface
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