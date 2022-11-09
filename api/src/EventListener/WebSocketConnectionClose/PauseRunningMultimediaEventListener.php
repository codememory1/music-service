<?php

namespace App\EventListener\WebSocketConnectionClose;

use App\Entity\UserSession;
use App\Event\WebSocketConnectionCloseEvent;
use App\Service\WebSocket\WorkerConnectionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(WebSocketConnectionCloseEvent::class, 'onConnectionClose')]
final class PauseRunningMultimediaEventListener
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly WorkerConnectionManager $workerConnectionManager
    ) {
    }

    public function onConnectionClose(WebSocketConnectionCloseEvent $event): void
    {
        $userSessionRepository = $this->em->getRepository(UserSession::class);
        $userSessionId = $this->workerConnectionManager->getUserSessionByConnectionId($event->message->connectionId);

        if (null !== $userSessionId) {
            $userSession = $userSessionRepository->find($userSessionId);
            $runningMultimedia = $userSession->getRunningMultimedia();

            if (null !== $runningMultimedia) {
                $runningMultimedia->pause();

                $this->em->flush();
            }
        }
    }
}