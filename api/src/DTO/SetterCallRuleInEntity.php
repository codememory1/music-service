<?php

namespace App\DTO;

use App\Enum\RoleEnum;
use App\Enum\RolePermissionEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Security\Auth\AuthorizedUser;

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
     * @var AuthorizedUser
     */
    private AuthorizedUser $authorizedUser;

    /**
     * @var bool
     */
    private bool $passed = true;

    /**
     * @param AuthorizedUser $authorizedUser
     */
    public function __construct(AuthorizedUser $authorizedUser)
    {
        $this->authorizedUser = $authorizedUser;
    }

    /**
     * @param RoleEnum $roleEnum
     *
     * @return $this
     */
    public function orRole(RoleEnum $roleEnum): self
    {
        $this->passed = $this->authorizedUser->hasRole($roleEnum);

        return $this;
    }

    /**
     * @param RolePermissionEnum $rolePermissionEnum
     *
     * @return $this
     */
    public function orRolePermission(RolePermissionEnum $rolePermissionEnum): self
    {
        $this->passed = $this->authorizedUser->hasRolePermission($rolePermissionEnum);

        return $this;
    }

    /**
     * @param SubscriptionPermissionEnum $subscriptionPermissionEnum
     *
     * @return $this
     */
    public function orSubscriptionPermission(SubscriptionPermissionEnum $subscriptionPermissionEnum): self
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