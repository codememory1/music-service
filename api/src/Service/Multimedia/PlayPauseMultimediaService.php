<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\RunningMultimedia;
use App\Entity\UserSession;
use App\Service\AbstractService;
use App\Service\MultimediaListeningHistory\UpsertListenService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class PlayPauseMultimediaService extends AbstractService
{
    #[Required]
    public ?UpsertListenService $upsertListenHistoryService = null;

    public function playPause(Multimedia $multimedia, UserSession $userSession): RunningMultimedia
    {
        $runningMultimediaRepository = $this->em->getRepository(RunningMultimedia::class);
        $runningMultimedia = $runningMultimediaRepository->findByMultimedia($multimedia);

        if (null !== $runningMultimedia) {
            $runningMultimedia->switchIsPlaying();
        } else {
            $runningMultimedia = new RunningMultimedia();

            $runningMultimedia->setUserSession($userSession);
            $runningMultimedia->setMultimedia($multimedia);
            $runningMultimedia->setCurrentTime(0.0);
            $runningMultimedia->play();
        }

        $this->flusherService->save($runningMultimedia);

        $this->upsertListenHistoryService->upsert($multimedia, $userSession->getUser(), $runningMultimedia->getCurrentTime());

        return $runningMultimedia;
    }

    public function request(Multimedia $multimedia, UserSession $userSession): JsonResponse
    {
        $runningMultimedia = $this->playPause($multimedia, $userSession);

        if ($runningMultimedia->isPlaying()) {
            return $this->responseCollection->successUpdate('multimedia@successPlay');
        }

        return $this->responseCollection->successUpdate('multimedia@successPause');
    }
}