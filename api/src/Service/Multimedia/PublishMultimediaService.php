<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PublishMultimediaService
{
    public function __construct(
        private readonly HttpResponseCollection $responseCollection,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function publish(Multimedia $multimedia): Multimedia
    {
        if ($multimedia->isPublished()) {
            throw MultimediaException::badPublish();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::PUBLISHED));

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->publish($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successPublish');
    }
}