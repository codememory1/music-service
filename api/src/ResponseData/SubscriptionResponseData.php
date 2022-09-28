<?php

namespace App\ResponseData;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class SubscriptionResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    private ?string $key = null;

    #[RDCV\AsTranslation]
    private ?string $title = null;

    #[RDCV\AsTranslation]
    private ?string $description = null;
    private ?float $oldPrice = null;
    private ?float $price = null;

    #[RDCS\MethodNamePrefix]
    private ?bool $isRecommend = null;
    private ?string $status = null;

    #[RDCV\CallbackResponseData(SubscriptionPermissionResponseData::class)]
    private array $permissions = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}