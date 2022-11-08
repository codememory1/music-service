<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;

use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MediaLibraryEventResponseData extends AbstractResponseData
{
    private ?string $key = null;
    private array $payload = [];

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}