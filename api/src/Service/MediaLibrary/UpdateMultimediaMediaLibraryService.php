<?php

namespace App\Service\MediaLibrary;

use App\DTO\MultimediaMediaLibraryDTO;
use App\Enum\EventEnum;
use App\Event\UpdateMultimediaMediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class UpdateMultimediaMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class UpdateMultimediaMediaLibraryService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function make(MultimediaMediaLibraryDTO $multimediaMediaLibraryDTO): JsonResponse
    {
        if (false === $this->validate($multimediaMediaLibraryDTO)) {
            return $this->validator->getResponse();
        }

        $this->em->flush();

        $this->eventDispatcher->dispatch(
            new UpdateMultimediaMediaLibraryEvent($multimediaMediaLibraryDTO->getEntity(), $multimediaMediaLibraryDTO),
            EventEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY->value
        );

        return $this->responseCollection->successUpdate('multimedia@successUpdate');
    }
}