<?php

namespace App\MessageHandler;

use App\Enum\EventEnum;
use App\Event\WebSocketConnectionCloseEvent;
use App\Message\WebSocketConnectionCloseMessage;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class WebSocketConnectionCloseMessageHandler
{
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public function __invoke(WebSocketConnectionCloseMessage $message): void
    {
        $this->eventDispatcher->dispatch(
            new WebSocketConnectionCloseEvent($message),
            EventEnum::WEB_SOCKET_CONNECTION_CLOSE->value
        );
    }
}