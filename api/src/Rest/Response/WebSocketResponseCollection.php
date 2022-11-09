<?php

namespace App\Rest\Response;

use App\Entity\Notification;
use App\Entity\StreamRunningMultimedia;
use App\Enum\PlatformCodeEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Rest\Response\Interfaces\WebSocketSchemeInterface;
use App\Rest\Response\Scheme\WebSocketSuccessScheme;
use App\Service\Translation;
use JetBrains\PhpStorm\Pure;

final class WebSocketResponseCollection
{
    public function __construct(
        private readonly Translation $translation
    ) {
    }

    public function setLocale(string $locale): self
    {
        $this->translation->setLocale($locale);

        return $this;
    }

    #[Pure]
    public function multimediaStreamAcceptRequest(StreamRunningMultimedia $streamRunningMultimedia): WebSocketSchemeInterface
    {
        return new WebSocketSuccessScheme(
            PlatformCodeEnum::PENDING,
            WebSocketClientMessageTypeEnum::MULTIMEDIA_STREAM_OFFER,
            [
                'stream_running_multimedia' => $streamRunningMultimedia->getId()
            ]
        );
    }

    public function userNotification(Notification $notification): WebSocketSchemeInterface
    {
        return new WebSocketSuccessScheme(
            PlatformCodeEnum::PENDING,
            WebSocketClientMessageTypeEnum::MULTIMEDIA_STREAM_OFFER,
            [
                'type' => $notification->getType(),
                'title' => $notification->getTitle(),
                'message' => $notification->getMessage(),
                'action' => $notification->getAction()
            ]
        );
    }
}