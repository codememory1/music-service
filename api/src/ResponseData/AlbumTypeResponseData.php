<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;
use App\ResponseData\Traits\ToTranslationHandlerTrait;

/**
 * Class AlbumTypeResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class AlbumTypeResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    use ToTranslationHandlerTrait;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUM_TYPES)]
    public ?int $id = null;
    public ?string $key = null;

    #[ResponseDataConstraints\Callback('handleToTranslation')]
    public ?string $title = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUM_TYPES)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_ALBUM_TYPES)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}