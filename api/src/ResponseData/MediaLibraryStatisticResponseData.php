<?php

namespace App\ResponseData;

use App\Entity\MultimediaMediaLibrary;
use App\ResponseData\Constraints as ResponseDataConstraints;

/**
 * Class MediaLibraryStatisticResponseData.
 *
 * @package App\ResponseData
 *
 * @author  Codememory
 */
class MediaLibraryStatisticResponseData extends AbstractResponseData
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

        $multimediaMediaLibraryResponseData->setEntities($multimediaMediaLibrary);
        $multimediaMediaLibraryResponseData->collect();

        return $multimediaMediaLibraryResponseData->getResponse(true);
    }
}