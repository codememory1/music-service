<?php

namespace App\DTO;

use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionPermissionEnum;

/**
 * Class SetterCallRuleInEntity.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SetterCallRuleInEntity
{
    /**
     * @var bool
     */
    private bool $passed = true;

    /**
     * @param RolePermissionEnum $permission
     *
     * @return $this
     */
    public function orRolePermission(RolePermissionEnum $permission): self
    {
        return $this;
    }

    /**
     * @param SubscriptionPermissionEnum $permission
     *
     * @return $this
     */
    public function orSubscriptionPermission(SubscriptionPermissionEnum $permission): self
    {
        return $this;
    }

    /**
     * @return bool
     */
    final public function isPassed(): bool
    {
        return $this->passed;
    }
}