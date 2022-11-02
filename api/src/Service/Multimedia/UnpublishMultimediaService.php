<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class UnpublishMultimediaService
{
    public function __construct(
        private readonly HttpResponseCollection $responseCollection,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function unpublish(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isPublished()) {
            throw MultimediaException::badUnpublish();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::UNPUBLISHED));

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->unpublish($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successUnpublish');
    }
}