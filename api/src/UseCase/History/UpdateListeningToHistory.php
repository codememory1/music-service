<?php

namespace App\UseCase\History;

use App\Entity\MultimediaListeningHistory;
use App\Infrastructure\Doctrine\Flusher;

final class UpdateListeningToHistory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaListeningHistory $multimediaListeningHistory, float $currentTime): MultimediaListeningHistory
    {
        $multimediaListeningHistory->setCurrentTime($currentTime);

        $this->flusher->save();

        return $multimediaListeningHistory;
    }
}