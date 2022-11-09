<?php

namespace App\Service\MediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaMediaLibrary
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibrary
    {
        $this->flusher->remove($multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }
}