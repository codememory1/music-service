<?php

namespace App\Rest\Response;

use App\Entity\Notification;
use App\Entity\StreamRunningMultimedia;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Service\TranslationService;

final class WebSocketResponseCollection
{
    public function __construct(
        private readonly WebSocketSchema $webSocketSchema,
        private readonly TranslationService $translation
    ) {}

    public function setLocale(string $locale): self
    {
        $this->translation->setLocale($locale);

        return $this;
    }

    public function multimediaStreamAcceptRequest(StreamRunningMultimedia $streamRunningMultimedia): WebSocketSchema
    {
        $schema = clone $this->webSocketSchema;

        $schema->setType(WebSocketClientMessageTypeEnum::MULTIMEDIA_STREAM_OFFER);
        $schema->setResult([
            'stream_running_multimedia' => $streamRunningMultimedia->getId()
        ]);

        return $schema;
    }

    public function userNotification(Notification $notification): WebSocketSchema
    {
        $schema = clone $this->webSocketSchema;

        $schema->setType(WebSocketClientMessageTypeEnum::USER_NOTIFICATION);
        $schema->setResult([
            'type' => $notification->getType(),
            'title' => $notification->getTitle(),
            'message' => $notification->getMessage(),
            'action' => $notification->getAction()
        ]);

        return $schema;
    }

    public function test(): WebSocketSchema
    {
        $schema = clone $this->webSocketSchema;

        $schema->setType(WebSocketClientMessageTypeEnum::USER_NOTIFICATION);
        $schema->setResult([
            'cd' => 123
        ]);

        return $schema;
    }
}