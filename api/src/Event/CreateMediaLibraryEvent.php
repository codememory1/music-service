<?php

namespace App\Event;

use App\Entity\MediaLibrary;

final class CreateMediaLibraryEvent
{
    public function __construct(
        public readonly MediaLibrary $mediaLibrary
    ) {
    }
}