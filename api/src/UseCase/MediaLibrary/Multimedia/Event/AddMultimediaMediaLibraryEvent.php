<?php

namespace App\UseCase\MultimediaMediaLibrary\Event;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\MediaLibrary\Multimedia\Event\EventPayloadHandler;

final class AddMultimediaMediaLibraryEvent
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

        $multimediaMediaLibraryEvent = $dto->getEntity();

        $multimediaMediaLibraryEvent->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $this->validator->validate($multimediaMediaLibrary);

        $this->eventPayloadHandler->handler($dto, $multimediaMediaLibrary);

        $this->flusher->save($multimediaMediaLibraryEvent);

        return $multimediaMediaLibraryEvent;
    }
}