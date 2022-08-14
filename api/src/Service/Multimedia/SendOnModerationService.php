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

class SendOnModerationService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function sendOnModeration(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isDraft()) {
            throw MultimediaException::badSendOnModeration();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::MODERATION),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $multimedia;
    }

    public function make(Multimedia $multimedia): JsonResponse
    {
        $this->sendOnModeration($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successSendOnModeration');
    }
}