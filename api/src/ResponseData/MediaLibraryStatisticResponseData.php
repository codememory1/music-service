<?php

namespace App\ResponseData;

use App\ResponseData\Constraints as ResponseDataConstraints;

final class MediaLibraryStatisticResponseData extends AbstractResponseData
{
    public int $numberOfTracks = 0;
    public int $numberOfClips = 0;
    public int $numberOfPlaylists = 0;

    #[ResponseDataConstraints\CallbackResponseData(MultimediaMediaLibraryResponseData::class, true)]
    public ?array $lastAddedMultimedia = null;
}