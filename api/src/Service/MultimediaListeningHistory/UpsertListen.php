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
        if (null === $owner->getMediaLibrary()) {
            return $this->createListen($multimedia, $owner, $currentTime);
        }

        $multimediaToMediaLibrary = $this->multimediaMediaLibraryRepository->findInMediaLibrary(
            $multimedia,
            $owner->getMediaLibrary()
        );

        if (null === $multimediaToMediaLibrary) {
            $this->createListen($multimedia, $owner, $currentTime);
        }

        return null;
    }

    public function createListen(Multimedia $multimedia, User $owner, float $currentTime): MultimediaListeningHistory
    {
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
}