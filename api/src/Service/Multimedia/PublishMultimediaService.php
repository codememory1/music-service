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

/**
 * Class PublishMultimediaService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class PublishMultimediaService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function make(Multimedia $multimedia): JsonResponse
    {
        if (MultimediaStatusEnum::PUBLISHED->name === $multimedia->getStatus()) {
            throw MultimediaException::badPublish();
        }

        $this->eventDispatcher->dispatch(
            new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::PUBLISHED),
            EventEnum::MULTIMEDIA_STATUS_CHANGE->value
        );

        return $this->responseCollection->successUpdate('multimedia@successPublish');
    }
}