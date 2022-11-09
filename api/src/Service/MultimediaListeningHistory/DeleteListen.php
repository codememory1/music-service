<?php

namespace App\Service\MultimediaListeningHistory;

use App\Entity\MultimediaListeningHistory;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteListen
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(MultimediaListeningHistory $multimediaListeningHistory): MultimediaListeningHistory
    {
        $this->flusher->remove($multimediaListeningHistory);

        return $multimediaListeningHistory;
    }
}