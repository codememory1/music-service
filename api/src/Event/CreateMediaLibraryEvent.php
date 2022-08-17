<?php

namespace App\Event;

use App\Entity\MediaLibrary;

final class CreateMediaLibraryEvent
{
    public readonly MediaLibrary $mediaLibrary;

    public function __construct(MediaLibrary $mediaLibrary)
    {
        $this->mediaLibrary = $mediaLibrary;
    }
}