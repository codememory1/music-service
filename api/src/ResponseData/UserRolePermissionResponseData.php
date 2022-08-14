<?php

namespace App\ResponseData;

use App\Entity\RolePermissionKey;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use JetBrains\PhpStorm\Pure;

final class UserRolePermissionResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\Callback('handlePermissionKey')]
    public ?string $permissionKey = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;

    #[Pure] 
    public function handlePermissionKey(?RolePermissionKey $rolePermissionKey): ?string
    {
        return $rolePermissionKey?->getKey();
    }
}