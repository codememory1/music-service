<?php

namespace App\DTO;

use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Security\AuthorizedUser;

/**
 * Class SetterCallRuleInEntity.
 *
 * @package App\DTO
 *
 * @author  Codememory
 */
class SetterCallRuleInEntity
{
    private AuthorizedUser $authorizedUser;
    private bool $passed = true;

    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    public function orRole(RoleEnum $roleEnum): self
    {
        $this->passed = $this->authorizedUser->isRole($roleEnum);

        return $this;
    }

    public function orRolePermission(RolePermissionEnum $rolePermissionEnum): self
    {
        $this->passed = $this->authorizedUser->isRolePermission($rolePermissionEnum);

        return $this;
    }

    public function orSubscriptionPermission(SubscriptionPermissionEnum $subscriptionPermissionEnum): self
    {
        $this->passed = $this->authorizedUser->isSubscriptionPermission($subscriptionPermissionEnum);

        return $this;
    }

    final public function isPassed(): bool
    {
        return $this->passed;
    }
}