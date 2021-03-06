<?php

namespace App\ResponseData;

use App\Entity\RolePermissionKey;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

/**
 * Class UserRolePermissionResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class UserRolePermissionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    /**
     * @var null|int
     */
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handlePermissionKey')]
    public ?string $permissionKey = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    /**
     * @param null|RolePermissionKey $rolePermissionKey
     *
     * @return null|string
     */
    public function handlePermissionKey(?RolePermissionKey $rolePermissionKey): ?string
    {
        return $rolePermissionKey?->getKey();
    }
}