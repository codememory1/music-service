<?php

namespace App\Service\MultimediaListeningHistory;

use App\Entity\Multimedia;
use App\Entity\MultimediaListeningHistory;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\MultimediaListeningHistoryRepository;
use App\Repository\MultimediaMediaLibraryRepository;

final class UpsertListen
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository,
        private readonly MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository
    ) {
    }

    public function save(Multimedia $multimedia, User $owner, float $currentTime): ?MultimediaListeningHistory
    {
        $multimediaToMediaLibrary = $this->multimediaMediaLibraryRepository->findOneByMultimedia($multimedia, $owner->getMediaLibrary());

        if (null === $multimediaToMediaLibrary) {
            $multimediaListeningHistory = $this->multimediaListeningHistoryRepository->findByUserAndMultimedia($owner, $multimedia);

            if (null === $multimediaListeningHistory) {
                $multimediaListeningHistory = new MultimediaListeningHistory();

                $multimediaListeningHistory->setUser($owner);
                $multimediaListeningHistory->setMultimedia($multimedia);
            }

            $multimediaListeningHistory->setCurrentTime($currentTime);

            $this->flusher->save($multimediaListeningHistory);

            return $multimediaListeningHistory;
        }

        return null;
    }
}