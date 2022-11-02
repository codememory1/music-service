<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use App\Rest\Response\HttpResponseCollection;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class SendOnAppealService
{
    public function __construct(
        private readonly HttpResponseCollection $responseCollection,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}
    
    public function sendOnAppeal(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isUnpublished() && false === $multimedia->isAppealCanceled()) {
            throw MultimediaException::badSendOnAppeal($multimedia->getStatus());
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL));

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->sendOnAppeal($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successSendOnAppeal');
    }
}