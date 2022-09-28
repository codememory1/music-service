<?php

namespace App\ResponseData;

use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class TranslationResponseData extends AbstractResponseData
{
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    private ?int $id = null;

    #[RDCV\CallbackResponseData(TranslationKeyResponseData::class, true)]
    private ?string $translationKey = null;
    private ?string $translation = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}