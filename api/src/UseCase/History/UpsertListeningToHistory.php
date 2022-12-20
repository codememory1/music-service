<?php

namespace App\UseCase\History;

use App\Entity\Multimedia;
use App\Entity\MultimediaListeningHistory;
use App\Entity\User;
use App\Repository\MultimediaListeningHistoryRepository;
use App\Repository\MultimediaMediaLibraryRepository;

final class UpsertListeningToHistory
{
    public function __construct(
        private readonly CreateListeningToHistory $createListeningToHistory,
        private readonly UpdateListeningToHistory $updateListeningToHistory,
        private readonly MultimediaMediaLibraryRepository $multimediaMediaLibraryRepository,
        private readonly MultimediaListeningHistoryRepository $multimediaListeningHistoryRepository
    ) {
    }

    public function process(Multimedia $multimedia, User $listening, float $currentTime): ?MultimediaListeningHistory
    {
        if (null === $listening->getMediaLibrary()) {
            return $this->upsert($multimedia, $listening, $currentTime);
        }

        $multimediaToMediaLibrary = $this->multimediaMediaLibraryRepository->findInMediaLibrary($multimedia, $listening->getMediaLibrary());

        if (null === $multimediaToMediaLibrary) {
            return $this->upsert($multimedia, $listening, $currentTime);
        }

        return null;
    }

    private function upsert(Multimedia $multimedia, User $listening, float $currentTime): MultimediaListeningHistory
    {
        $listeningToHistory = $this->multimediaListeningHistoryRepository->findByUserAndMultimedia($listening, $multimedia);

        if (null === $listeningToHistory) {
            return $this->createListeningToHistory->process($multimedia, $listening, $currentTime);
        }

        return $this->updateListeningToHistory->process($listeningToHistory, $currentTime);
    }
}