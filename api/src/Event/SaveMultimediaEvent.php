<?php

namespace App\Event;

use App\Entity\Multimedia;

final class SaveMultimediaEvent
{
    public function __construct(
        public readonly Multimedia $multimedia
    ) {
    }
}