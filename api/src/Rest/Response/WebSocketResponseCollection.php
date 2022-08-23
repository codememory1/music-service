<?php

namespace App\Rest\Response;

use App\Entity\StreamRunningMultimedia;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Service\TranslationService;

final class WebSocketResponseCollection
{
    private WebSocketSchema $webSocketSchema;
    private TranslationService $translationService;

    public function __construct(WebSocketSchema $webSocketSchema, TranslationService $translationService)
    {
        $this->webSocketSchema = $webSocketSchema;
        $this->translationService = $translationService;
    }

    public function setLocale(string $locale): self
    {
        $this->translationService->setLocale($locale);

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
}