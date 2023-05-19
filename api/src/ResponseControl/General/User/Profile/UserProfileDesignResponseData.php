<?php

namespace App\ResponseData\General\User\Profile;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class UserProfileDesignResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(UserProfileResponseData::class, onlyProperties: ['id', 'pseudonym'])]
    private array $userProfile = [];
    private ?string $coverImage = null;
    private array $designComponents = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}