<?php

namespace App\UseCase\History;

use App\Entity\Multimedia;
use App\Entity\MultimediaListeningHistory;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;

final class CreateListeningToHistory
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(Multimedia $multimedia, User $listening, float $currentTime): MultimediaListeningHistory
    {
        $multimediaListeningHistory = new MultimediaListeningHistory();

        $multimediaListeningHistory->setUser($listening);
        $multimediaListeningHistory->setMultimedia($multimedia);
        $multimediaListeningHistory->setCurrentTime($currentTime);

        $this->flusher->save($multimediaListeningHistory);

        return $multimediaListeningHistory;
    }
}