<?php

namespace App\EventListener\WebSocketConnectionClose;

use App\Entity\UserSession;
use App\Event\WebSocketConnectionCloseEvent;
use App\Repository\StreamRunningMultimediaRepository;
use App\Repository\UserSessionRepository;
use App\Service\WebSocket\WorkerConnectionManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('app.ws.connection.close', 'onConnectionClose')]
final class RejectStreamRunningMultimediaEventListener
{
    private EntityManagerInterface $em;
    private UserSessionRepository $userSessionRepository;
    private StreamRunningMultimediaRepository $streamRunningMultimediaRepository;
    private WorkerConnectionManager $workerConnectionManager;

    public function __construct(
        EntityManagerInterface $manager,
        UserSessionRepository $userSessionRepository,
        StreamRunningMultimediaRepository $streamRunningMultimediaRepository,
        WorkerConnectionManager $workerConnectionManager
    ) {
        $this->em = $manager;
        $this->userSessionRepository = $userSessionRepository;
        $this->streamRunningMultimediaRepository = $streamRunningMultimediaRepository;
        $this->workerConnectionManager = $workerConnectionManager;
    }

    public function onConnectionClose(WebSocketConnectionCloseEvent $event): void
    {
        if (null !== $userSession = $this->getUserSession($event->message->connectionId)) {
            $streamRunningMultimedia = $this->streamRunningMultimediaRepository->findByUserSession($userSession);

            if (null !== $streamRunningMultimedia) {
                $this->em->remove($streamRunningMultimedia);
                $this->em->flush();
            }
        }
    }

    private function getUserSession(int $connectionId): ?UserSession
    {
        $userSessionId = $this->workerConnectionManager->getUserSessionByConnectionId($connectionId);

        if (null !== $userSessionId) {
            return null;
        }

        return $this->userSessionRepository->find($userSessionId);
    }
}