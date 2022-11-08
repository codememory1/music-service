<?php

namespace App\Service\MultimediaListeningHistory;

use App\Entity\MultimediaListeningHistory;
use App\Service\FlusherService;

final class DeleteListen
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(MultimediaListeningHistory $multimediaListeningHistory): MultimediaListeningHistory
    {
        $this->flusher->remove($multimediaListeningHistory);

        return $multimediaListeningHistory;
    }
}