<?php

namespace App\ResponseData;

use App\Enum\RolePermissionEnum;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class TranslationResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    public ?int $id = null;

    #[ResponseDataConstraints\CallbackResponseData(TranslationKeyResponseData::class, true)]
    public ?string $translationKey = null;
    public ?string $translation = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_TRANSLATIONS)]
    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}