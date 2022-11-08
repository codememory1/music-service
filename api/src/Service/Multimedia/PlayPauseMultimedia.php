<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\RunningMultimedia;
use App\Entity\UserSession;
use App\Repository\RunningMultimediaRepository;
use App\Service\FlusherService;
use App\Service\MultimediaListeningHistory\UpsertListen;

class PlayPauseMultimedia
{
    public function __construct(
        private readonly RunningMultimediaRepository $runningMultimediaRepository,
        private readonly FlusherService $flusher,
        private readonly UpsertListen $upsertListenHistory,
        private readonly AddAudition $addAudition
    ) {
    }

    public function playPause(Multimedia $multimedia, UserSession $listenerSession): RunningMultimedia
    {
        $runningMultimedia = $this->runningMultimediaRepository->findByMultimedia($multimedia);

        if (null !== $runningMultimedia) {
            $runningMultimedia->switchIsPlaying();
        } else {
            $runningMultimedia = new RunningMultimedia();

            $runningMultimedia->setUserSession($listenerSession);
            $runningMultimedia->setMultimedia($multimedia);
            $runningMultimedia->setCurrentTime(0.0);
            $runningMultimedia->play();
        }

        $this->flusher->save($runningMultimedia);

        $this->upsertListenHistory->save($multimedia, $listenerSession->getUser(), $runningMultimedia->getCurrentTime());

        $this->addAudition->add($multimedia, $listenerSession->getUser());

        return $runningMultimedia;
    }
}