<?php

namespace App\Service\MultimediaListeningHistory;

use App\Entity\Multimedia;
use App\Entity\MultimediaListeningHistory;
use App\Entity\User;
use App\Repository\MultimediaListeningHistoryRepository;
use App\Repository\MultimediaMediaLibraryRepository;
use App\Service\FlusherService;

final class UpsertListenService
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository,
        private readonly MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository
    ) {
    }

    public function upsert(Multimedia $multimedia, User $toUser, float $currentTime): ?MultimediaListeningHistory
    {
        $multimediaToMediaLibrary = $this->multimediaMediaLibraryRepository->findOneBy([
            'multimedia' => $multimedia,
            'mediaLibrary' => $toUser->getMediaLibrary()
        ]);

        if (null === $multimediaToMediaLibrary) {
            $listen = $this->multimediaListeningHistoryRepository->findByUserAndMultimedia($toUser, $multimedia);

            if (null === $listen) {
                $listen = new MultimediaListeningHistory();

                $listen->setUser($toUser);
                $listen->setMultimedia($multimedia);
            }

            $listen->setCurrentTime($currentTime);

            $this->flusher->save($listen);

            return $listen;
        }

        return null;
    }
}