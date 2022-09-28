<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MultimediaMetadataResponseData extends AbstractResponseData
{
    private ?float $duration = null;
    private ?int $bitrate = null;
    private ?int $framerate = null;

    #[RDCS\MethodNamePrefix]
    private bool $isLossless = false;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}