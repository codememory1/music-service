<?php

namespace App\ResponseData\General\Multimedia;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;

final class MultimediaAuditionResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private array $user = [];

    #[RDCS\Prefix('is', 'is')]
    private bool $full = false;

    #[RDCV\DateTime]
    private ?string $createdAt = null;
}