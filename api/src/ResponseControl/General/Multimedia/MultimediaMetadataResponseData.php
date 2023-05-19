<?php

namespace App\ResponseData\General\Multimedia;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaMetadataResponseData extends AbstractResponseData
{
    private ?float $duration = null;
    private ?int $bitrate = null;
    private ?int $framerate = null;

    #[RDCS\Prefix('is', 'is')]
    private bool $lossless = false;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}