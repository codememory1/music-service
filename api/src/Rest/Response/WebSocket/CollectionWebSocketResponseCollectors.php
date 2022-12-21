<?php

namespace App\Rest\Response\WebSocket;

use App\Entity\Notification;
use App\Entity\StreamRunningMultimedia;
use App\Enum\PlatformCodeEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\Interfaces\SuccessWebSocketResponseCollectorInterface;
use App\Rest\Response\Interfaces\WebSocketResponseCollectorInterface;
use App\Service\Translation;

final class CollectionWebSocketResponseCollectors
{
    public function __construct(
        private readonly Translation $translation,
        private readonly SuccessWebSocketResponseCollectorInterface $successWebSocketResponseCollector
    ) {
    }

    public function setLocale(string $locale): self
    {
        $this->translation->setLocale($locale);

        return $this;
    }

    public function multimediaStreamAcceptRequest(StreamRunningMultimedia $streamRunningMultimedia): WebSocketResponseCollectorInterface
    {
        $this->successWebSocketResponseCollector->setPlatformCode(PlatformCodeEnum::PENDING);
        $this->successWebSocketResponseCollector->setClientType(WebSocketClientMessageTypeEnum::MULTIMEDIA_STREAM_OFFER);
        $this->successWebSocketResponseCollector->setData(['stream_running_multimedia' => $streamRunningMultimedia->getId()]);

        return $this->successWebSocketResponseCollector;
    }

    public function userNotification(Notification $notification): WebSocketResponseCollectorInterface
    {
        $this->successWebSocketResponseCollector->setPlatformCode(PlatformCodeEnum::PENDING);
        $this->successWebSocketResponseCollector->setClientType(WebSocketClientMessageTypeEnum::MULTIMEDIA_STREAM_OFFER);
        $this->successWebSocketResponseCollector->setData([
            'type' => $notification->getType(),
            'title' => $notification->getTitle(),
            'message' => $notification->getMessage(),
            'action' => $notification->getAction()
        ]);

        return $this->successWebSocketResponseCollector;
    }
}