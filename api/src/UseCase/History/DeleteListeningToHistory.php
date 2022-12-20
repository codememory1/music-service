<?php

namespace App\UseCase\History;

use App\Entity\MultimediaListeningHistory;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteListeningToHistory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaListeningHistory $multimediaListeningHistory): MultimediaListeningHistory
    {
        $this->flusher->remove($multimediaListeningHistory);

        return $multimediaListeningHistory;
    }
}