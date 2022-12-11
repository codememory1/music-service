<?php

namespace App\UseCase\Multimedia;

use App\Entity\Multimedia;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimedia
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly DeleteMultimediaFiles $deleteMultimediaFiles
    ) {
    }

    public function process(Multimedia $multimedia): Multimedia
    {
        $this->deleteMultimediaFiles->process($multimedia);

        $this->flusher->remove($multimedia);

        return $multimedia;
    }
}