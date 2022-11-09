<?php

namespace App\ResponseData\General\Multimedia;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\System as RDCS;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class RunningMultimediaResponseData extends AbstractResponseData
{
    #[RDCV\CallbackResponseData(MultimediaResponseData::class, onlyProperties: ['id'])]
    private array $multimedia = [];
    private ?float $currentTime = null;

    #[RDCS\Prefix('is', 'is')]
    private bool $playing = false;

    #[RDCV\DateTime]
    private ?string $createdAt = null;

    #[RDCV\DateTime]
    private ?string $updatedAt = null;
}