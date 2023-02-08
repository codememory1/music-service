<?php

namespace App\ResponseData\General\User\AuthorizedUser;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\Subscription\SubscriptionResponseData;
use App\ResponseData\General\User\UserSettingResponseData;
use App\ResponseData\General\UserRole\UserRoleResponseData;

final class AuthorizedUserResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $email = null;

    #[RDCV\CallbackResponseData(UserRoleResponseData::class)]
    private array $role = [];

    #[RDCV\CallbackResponseData(AuthorizedUserProfileResponseData::class)]
    private array $profile = [];

    private ?string $status = null;

    #[RDCV\CallbackResponseData(SubscriptionResponseData::class, onlyProperties: ['id', 'permissions'])]
    private array $subscription = [];

    #[RDCV\CallbackResponseData(UserSettingResponseData::class, ignoreProperties: ['user'])]
    private array $settings = [];
}