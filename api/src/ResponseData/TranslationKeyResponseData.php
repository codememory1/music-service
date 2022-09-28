<?php

namespace App\ResponseData;

use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class TranslationKeyResponseData extends \App\Infrastructure\ResponseData\AbstractResponseData
{
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    public ?int $id = null;
    public ?string $key = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[RDCV\DateTime]
    public ?string $createdAt = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[RDCV\DateTime]
    public ?string $updatedAt = null;
}