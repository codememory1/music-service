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

class UnpublishMultimediaService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function unpublish(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isPublished()) {
            throw MultimediaException::badUnpublish();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::UNPUBLISHED),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $multimedia;
    }

    public function request(Multimedia $multimedia): JsonResponse
    {
        $this->unpublish($multimedia);

        return $this->responseCollection->successUpdate('multimedia@successUnpublish');
    }
}