<?php

namespace App\UseCase\MediaLibrary\Multimedia;

use App\Entity\MultimediaMediaLibrary;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaMediaLibrary
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibrary
    {
        $this->flusher->remove($multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }
}