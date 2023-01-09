<?php

namespace App\ResponseData\General\Subscription;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class SubscriptionExtenderResponseData extends AbstractResponseData
{
    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?int $id = null;

    #[RDCV\CallbackResponseData(SubscriptionResponseData::class, onlyProperties: ['id', 'title'])]
    private array $subscription = [];

    #[RDCV\CallbackResponseData(SubscriptionResponseData::class, onlyProperties: ['id', 'title'])]
    private array $basicSubscription = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    #[RDCV\DateTime]
    private ?string $createdAt = null;
}