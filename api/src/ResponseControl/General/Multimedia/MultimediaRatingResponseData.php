<?php

namespace App\ResponseData\General\Multimedia;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;

final class MultimediaRatingResponseData extends AbstractResponseData
{
    private ?int $id = null;
    private ?string $type = null;

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private array $user = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}