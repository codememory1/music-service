<?php

namespace App\ResponseData\User;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(UserProfileResponseData::class, true)]
    private array $profile = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?string $email = null;

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private array $role = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private array $subscription = [];

    #[RDCA\RequestType(RequestTypeEnum::ADMIN)]
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}