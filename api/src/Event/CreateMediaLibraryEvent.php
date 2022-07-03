<?php

namespace App\Event;

use App\Entity\MediaLibrary;

/**
 * Class CreateMediaLibraryEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class CreateMediaLibraryEvent
{
    public readonly MediaLibrary $mediaLibrary;

    public function __construct(MediaLibrary $mediaLibrary)
    {
        $this->mediaLibrary = $mediaLibrary;
    }
}