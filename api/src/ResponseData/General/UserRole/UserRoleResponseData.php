<?php

namespace App\ResponseData\General\UserRole;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserRoleResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $key = null;

    #[RDCV\AsTranslation]
    private ?string $title = null;

    #[RDCV\AsTranslation]
    private ?string $shortDescription = null;

    #[RDCV\CallbackResponseData(UserRolePermissionResponseData::class)]
    private array $permissions = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}