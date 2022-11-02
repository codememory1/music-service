<?php

namespace App\MessageHandler;

use App\Event\WebSocketConnectionCloseEvent;
use App\Message\WebSocketConnectionCloseMessage;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class WebSocketConnectionCloseMessageHandler
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function __invoke(WebSocketConnectionCloseMessage $message): void
    {
        $this->eventDispatcher->dispatch(new WebSocketConnectionCloseEvent($message));
    }
}