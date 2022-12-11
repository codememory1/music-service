<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Entity\RunningMultimedia;
use App\Entity\UserSession;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\RunningMultimediaRepository;
use App\Service\MultimediaListeningHistory\UpsertListen;
use App\UseCase\Multimedia\AddMultimediaListener;

final class ToggleMultimediaPlayback
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly RunningMultimediaRepository $runningMultimediaRepository,
        private readonly UpsertListen $upsertListenHistory,
        private readonly AddMultimediaListener $addMultimediaListener
    ) {
    }

    public function process(Multimedia $multimedia, UserSession $listenerSession): RunningMultimedia
    {
        $runningMultimedia = tap($this->runningMultimediaRepository->findByMultimedia($multimedia), static function() use ($listenerSession, $multimedia) {
            $runningMultimedia = new RunningMultimedia();

            $runningMultimedia->setUserSession($listenerSession);
            $runningMultimedia->setMultimedia($multimedia);
            $runningMultimedia->setCurrentTime(0.0);
            $runningMultimedia->play();

            return $runningMultimedia;
        });

        $this->flusher->save($runningMultimedia);

        $this->upsertListenHistory->save($multimedia, $listenerSession->getUser(), $runningMultimedia->getCurrentTime());

        $this->addMultimediaListener->process($multimedia, $listenerSession->getUser());

        return $runningMultimedia;
    }
}