<?php

namespace App\ResponseData;

use App\Entity\MultimediaMediaLibrary;
use App\ResponseData\Constraints as ResponseDataConstraints;

final class MediaLibraryStatisticResponseData extends AbstractResponseData
{
    public int $numberOfTracks = 0;
    public int $numberOfClips = 0;
    public int $numberOfPlaylists = 0;

    #[ResponseDataConstraints\Callback('handleLastAddedMultimedia')]
    public ?array $lastAddedMultimedia = null;

    public function handleLastAddedMultimedia(?MultimediaMediaLibrary $multimediaMediaLibrary): array
    {
        $multimediaMediaLibraryResponseData = new MultimediaMediaLibraryResponseData($this->container);

        if (null === $multimediaMediaLibrary) {
            return [];
        }

        return $multimediaMediaLibraryResponseData->setEntities($multimediaMediaLibrary)->getResponse(true);
    }
}