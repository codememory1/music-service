<?php

namespace App\ResponseData;

use App\Entity\RolePermissionKey;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserRolePermissionResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\Callback('handlePermissionKey')]
    private ?string $permissionKey = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;

    public function handlePermissionKey(?RolePermissionKey $rolePermissionKey): ?string
    {
        return $rolePermissionKey?->getKey();
    }
}