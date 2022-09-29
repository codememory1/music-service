<?php

namespace App\ResponseData;

use App\Entity\User;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\User\UserResponseData;

final class MultimediaShared extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private ?User $fromUser = null;

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private ?User $toUser = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;
}