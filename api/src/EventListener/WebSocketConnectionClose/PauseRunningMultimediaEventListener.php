<?php

namespace App\EventListener\WebSocketConnectionClose;

use App\Entity\UserSession;
use App\Event\WebSocketConnectionCloseEvent;
use App\Service\WebSocket\WorkerConnectionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('app.ws.connection.close', 'onConnectionClose')]
final class PauseRunningMultimediaEventListener
{
    private EntityManagerInterface $em;
    private WorkerConnectionManager $workerConnectionManager;

    public function __construct(EntityManagerInterface $manager, WorkerConnectionManager $workerConnectionManager)
    {
        $this->em = $manager;
        $this->workerConnectionManager = $workerConnectionManager;
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