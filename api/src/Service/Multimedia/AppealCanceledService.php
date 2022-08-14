<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Rest\Http\Exceptions\MultimediaException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class AppealCanceledService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function appeal(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isAppeal()) {
            throw MultimediaException::badAppealCanceled();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL_CANCELED),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->appeal($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successAppealCanceled');
    }
}