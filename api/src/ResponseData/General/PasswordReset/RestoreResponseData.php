<?php

namespace App\ResponseData\General\PasswordReset;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\AuthorizedUser\AuthorizedUserResponseData;

final class RestoreResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(AuthorizedUserResponseData::class, onlyProperties: ['id', 'email'])]
    private array $user = [];
    private ?int $code = null;
    private ?string $status = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}