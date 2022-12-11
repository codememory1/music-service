<?php

namespace App\UseCase\MediaLibrary\Event;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\MediaLibrary\Event\EventPayloadHandler;

final class AddMediaLibraryEvent
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly EventPayloadHandler $eventPayloadHandler
    ) {
    }

    public function process(MediaLibraryEventDto $dto, MediaLibrary $mediaLibrary): MediaLibraryEvent
    {
        $this->validator->validate($dto);

        $mediaLibraryEvent = $dto->getEntity();

        $mediaLibraryEvent->setMediaLibrary($mediaLibrary);

        $this->validator->validate($mediaLibraryEvent);

        $this->eventPayloadHandler->handler($dto, $mediaLibrary);

        $this->flusher->save($mediaLibraryEvent);

        return $mediaLibraryEvent;
    }
}