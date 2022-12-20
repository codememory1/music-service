<?php

namespace App\ResponseData\General\User;

use App\Enum\SubscriptionPermissionEnum;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Availability as RDCA;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserSettingResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id', 'email', 'profile'])]
    private array $user = [];

    #[RDCS\Prefix('is', 'is')]
    private bool $acceptMultimediaFromFriends = false;
    private array $multimediaStream = [];

    #[RDCS\Prefix('is', 'is')]
    #[RDCA\SubscriptionPermission(SubscriptionPermissionEnum::USER_SETTING_HIDE_MY_MULTIMEDIA)]
    private bool $hideMyMultimedia = false;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}