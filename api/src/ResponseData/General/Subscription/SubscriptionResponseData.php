<?php

namespace App\ResponseData\General\Subscription;

use App\Enum\RequestTypeEnum;
use App\Enum\RolePermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class SubscriptionResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\AsTranslation]
    private ?string $title = null;

    #[RDCV\AsTranslation]
    private ?string $description = null;
    private ?float $oldPrice = null;
    private ?float $price = null;

    #[RDCS\Prefix('is', 'is')]
    private ?bool $recommend = null;
    private ?string $status = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\CallbackResponseData(SubscriptionPermissionResponseData::class)]
    private array $permissions = [];

    #[RDCV\CallbackResponseData(SubscriptionPermissionResponseData::class)]
    private array $uniquePermissions = [];

    #[RDCS\AliasInResponse('expands_from')]
    #[RDCV\CallbackResponseData(SubscriptionExtenderResponseData::class, onlyProperties: ['id', 'basicSubscription'])]
    private array $extenders = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCA\RolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}