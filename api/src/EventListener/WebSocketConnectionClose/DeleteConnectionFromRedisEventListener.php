<?php

namespace App\EventListener\WebSocketConnectionClose;

use App\Event\WebSocketConnectionCloseEvent;
use App\Service\WebSocket\WorkerConnectionManager;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(WebSocketConnectionCloseEvent::class, 'onConnectionClose', priority: -256)]
final class DeleteConnectionFromRedisEventListener
{
    private WorkerConnectionManager $workerConnectionManager;

    public function __construct(WorkerConnectionManager $workerConnectionManager)
    {
        $this->workerConnectionManager = $workerConnectionManager;
    }

    public function onConnectionClose(WebSocketConnectionCloseEvent $event): void
    {
        $this->workerConnectionManager->deleteConnection($event->message->connectionId);
    }
}