<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class SubscriptionPermissionResponseData extends AbstractResponseData
{
    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?int $id = null;

    #[RDCV\CallbackResponseData(SubscriptionPermissionKeyResponseData::class)]
    private array $permissionKey = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}