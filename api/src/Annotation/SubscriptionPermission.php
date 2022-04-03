<?php

namespace App\Annotation;

use App\Entity\SubscriptionPermissionName;
use App\Enum\SubscriptionPermissionNameEnum;
use Attribute;

/**
 * Class SubscriptionPermission.
 *
 * @package App\Annotation
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_METHOD)]
class SubscriptionPermission
{
    /**
     * @var SubscriptionPermissionName
     */
    public SubscriptionPermissionName $permission;

    /**
     * @param SubscriptionPermissionNameEnum $permission
     */
    public function __construct(SubscriptionPermissionNameEnum $permission)
    {
        $subscriptionPermissionNameEntity = new SubscriptionPermissionName();

        $subscriptionPermissionNameEntity->setKey($permission->value);

        $this->permission = $subscriptionPermissionNameEntity;
    }
}