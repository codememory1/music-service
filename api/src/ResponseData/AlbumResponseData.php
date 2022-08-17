<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class AlbumResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\CallbackResponseData(AlbumTypeResponseData::class, true)]
    public ?string $type = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $image = null;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaResponseData::class, ignoreProperties: ['album'])]
    public array $multimedia = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUMS)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDatetime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDatetime')]
    public ?string $updatedAt = null;
}