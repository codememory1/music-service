<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class AppealCanceledService
{
    public function __construct(
        private readonly HttpResponseCollection $responseCollection,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}
    
    public function appeal(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isAppeal()) {
            throw MultimediaException::badAppealCanceled();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL_CANCELED));

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->appeal($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successAppealCanceled');
    }
}