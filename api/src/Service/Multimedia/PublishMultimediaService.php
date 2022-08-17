<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\EventEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class PublishMultimediaService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function publish(Multimedia $multimedia): Multimedia
    {
        if ($multimedia->isPublished()) {
            throw MultimediaException::badPublish();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::PUBLISHED),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->publish($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successPublish');
    }
}