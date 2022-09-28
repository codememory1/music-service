<?php

namespace App\ResponseData;

use App\Infrastructure\ResponseData\AbstractResponseData;
use App\Infrastructure\ResponseData\Constraints\Value as RDCV;

final class MediaLibraryStatisticResponseData extends AbstractResponseData
{
    private int $numberOfTracks = 0;
    private int $numberOfClips = 0;
    private int $numberOfPlaylists = 0;

    #[RDCV\CallbackResponseData(MultimediaMediaLibraryResponseData::class, true)]
    private ?array $lastAddedMultimedia = null;
}