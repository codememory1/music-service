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
    private FlusherService $flusher;
    private MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository;
    private MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository;

    public function __construct(FlusherService $flusherService, MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository, MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository)
    {
        $this->flusher = $flusherService;
        $this->multimediaMediaLibraryRepository = $multimediaMediaLibraryRepository;
        $this->multimediaListeningHistoryRepository = $multimediaListeningHistoryRepository;
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