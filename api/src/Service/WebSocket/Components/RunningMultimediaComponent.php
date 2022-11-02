<?php

namespace App\Service\WebSocket\Components;

use App\Entity\RunningMultimedia;
use App\Entity\UserSession;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;
use App\Repository\RunningMultimediaRepository;

final class RunningMultimediaComponent
{
    public function __construct(
        private readonly RunningMultimediaRepository $runningMultimediaRepository
    ) {}

    public function getRunningMultimedia(int $id, UserSession $userSession, WebSocketClientMessageTypeEnum $clientMessageType): RunningMultimedia
    {
        $runningMultimedia = $this->runningMultimediaRepository->findByIdAndUserSession($id, $userSession);

        if (null === $runningMultimedia) {
            throw EntityNotFoundException::runningMultimedia($clientMessageType);
        }

        return $runningMultimedia;
    }
}