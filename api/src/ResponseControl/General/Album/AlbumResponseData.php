<?php

namespace App\ResponseData\General\Album;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\Multimedia\MultimediaResponseData;

final class AlbumResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(AlbumTypeResponseData::class)]
    private ?string $type = null;
    private ?string $title = null;
    private ?string $description = null;
    private ?string $image = null;

    #[RDCV\CallbackResponseData(MultimediaResponseData::class, ['album'])]
    private array $multimedia = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}