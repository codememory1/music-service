<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SendOnModerationService
{
    public function __construct(
        private readonly HttpResponseCollection $responseCollection,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function sendOnModeration(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isDraft()) {
            throw MultimediaException::badSendOnModeration();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::MODERATION));

        return $multimedia;
    }

    public function make(Multimedia $multimedia): JsonResponse
    {
        $this->sendOnModeration($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successSendOnModeration');
    }
}