<?php

namespace App\UseCase\MediaLibrary\Multimedia\Event;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\MediaLibrary\Multimedia\Event\EventPayloadHandler;

final class UpdateMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly EventPayloadHandler $eventPayloadHandler
    ) {
    }

    public function process(MultimediaMediaLibraryEventDto $dto, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibraryEvent
    {
        $this->validator->validate($dto);

        $mediaLibraryMultimediaEvent = $dto->getEntity();

        $this->validator->validate($mediaLibraryMultimediaEvent);

        $this->eventPayloadHandler->handler($dto, $multimediaMediaLibrary);

        $this->flusher->save();

        return $mediaLibraryMultimediaEvent;
    }
}