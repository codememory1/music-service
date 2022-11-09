<?php

namespace App\ResponseData\General\Artist;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;
use App\ResponseData\General\User\UserResponseData;

final class ArtistSubscriberResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private array $artist = [];

    #[RDCV\CallbackResponseData(UserResponseData::class, onlyProperties: ['id'])]
    private array $subscriber = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}