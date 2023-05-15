<?php

namespace App\ResponseData\General\Multimedia;

use App\Entity\User;
use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;

final class MultimediaSharedResponseData extends AbstractResponseData
{
    private ?int $id = null;

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private ?User $fromUser = null;

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private ?User $toUser = null;

    #[RDCV\DateTime]
    private ?string $createdAt = null;
}