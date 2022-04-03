<?php

namespace App\Validator\Constraints;

use App\Enum\RolePermissionNameEnum;
use Attribute;
use Symfony\Component\Validator\Constraint;

/**
 * Class UserPermission.
 *
 * @package App\Validator\Constraints
 *
 * @author  Codememory
 */
#[Attribute(Attribute::TARGET_CLASS)]
class UserPermission extends Constraint
{
    /**
     * @var string
     */
    public string $rolePermissionName;

    /**
     * @var string
     */
    public string $message = 'Insufficient rights to perform this action';

    /**
     * @param null|string $message
     * @param null|mixed  $options
     * @param null|array  $groups
     * @param null|mixed  $payload
     */
    public function __construct(RolePermissionNameEnum $permissionNameEnum, ?string $message = null, mixed $options = null, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct($options, $groups, $payload);

        $this->rolePermissionName = $permissionNameEnum->value;
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT];
    }
}