<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\RunningMultimedia;
use App\Entity\UserSession;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use App\Service\MultimediaListeningHistory\UpsertListenService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PlayPauseMultimediaService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection,
        private readonly UpsertListenService $upsertListenHistoryService,
        private readonly AddAuditionService $addAuditionService
    ) {}

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
        $this->addAuditionService->add($multimedia, $userSession->getUser());

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