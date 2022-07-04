<?php

namespace App\Event;

use App\DTO\MultimediaMediaLibraryDTO;
use App\Entity\MultimediaMediaLibrary;

/**
 * Class UpdateMultimediaMediaLibraryEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class UpdateMultimediaMediaLibraryEvent
{
    public readonly MultimediaMediaLibrary $multimediaMediaLibrary;
    public readonly MultimediaMediaLibraryDTO $multimediaMediaLibraryDTO;

    public function __construct(MultimediaMediaLibrary $multimediaMediaLibrary, MultimediaMediaLibraryDTO $multimediaMediaLibraryDTO)
    {
        $this->multimediaMediaLibrary = $multimediaMediaLibrary;
        $this->multimediaMediaLibraryDTO = $multimediaMediaLibraryDTO;
    }
}