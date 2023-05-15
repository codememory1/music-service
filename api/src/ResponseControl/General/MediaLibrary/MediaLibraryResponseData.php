<?php

namespace App\ResponseData\General\MediaLibrary;

use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;

final class MediaLibraryResponseData extends AbstractResponseData
{
    #[RDCA\RolePermission(RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER)]
    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id', 'profile', 'email'])]
    private array $user = [];
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}