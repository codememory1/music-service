<?php

namespace App\ResponseData\General\User;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserSettingResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id', 'email', 'profile'])]
    private array $user = [];

    #[RDCS\Prefix('is', 'is')]
    private bool $acceptMultimediaFromFriends = false;
    private array $multimediaStream = [];

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}