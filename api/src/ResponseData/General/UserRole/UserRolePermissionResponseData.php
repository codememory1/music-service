<?php

namespace App\ResponseData\General\UserRole;

use App\Entity\Interfaces\EntityInterface;
use App\Entity\RolePermissionKey;
use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;

final class UserRolePermissionResponseData extends AbstractResponseData
{
    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?int $id = null;

    #[RDCV\Callback('handlePermissionKey')]
    private ?string $permissionKey = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;

    public function handlePermissionKey(EntityInterface $entity, ?RolePermissionKey $rolePermissionKey): ?string
    {
        return $rolePermissionKey?->getKey();
    }
}