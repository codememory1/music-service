<?php

namespace App\ResponseData\General\User;

use App\Enum\RequestTypeEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\Profile\UserProfileResponseData;

final class UserResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(UserProfileResponseData::class)]
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