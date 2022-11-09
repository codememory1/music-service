<?php

namespace App\ResponseData\General\PasswordReset;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;

final class RequestRestorationResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id', 'email'])]
    private array $user = [];
    private ?string $status = null;
    private ?int $ttl = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;
}