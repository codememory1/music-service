<?php

namespace App\ResponseData\User;

use App\Enum\RequestTypeEnum;
use App\ResponseData\AbstractResponseData;
use App\ResponseData\Constraints as ResponseDataConstraints;
use App\ResponseData\Interfaces\ResponseDataInterface;
use App\ResponseData\Traits\DateTimeHandlerTrait;

final class UserResponseData extends AbstractResponseData implements ResponseDataInterface
{
    use DateTimeHandlerTrait;
    public ?int $id = null;

    #[ResponseDataConstraints\CallbackResponseData(UserProfileResponseData::class, true)]
    public array $profile = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $email = null;

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public array $role = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public array $subscription = [];

    #[ResponseDataConstraints\RequestType(RequestTypeEnum::ADMIN)]
    public ?string $status = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $createdAt = null;

    #[ResponseDataConstraints\Callback('handleDateTime')]
    public ?string $updatedAt = null;
}