<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Validator\Validator;

final class UpdateMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly UpsertMultimediaMediaLibraryEvent $upsertMultimediaMediaLibraryEvent,
        private readonly Validator $validator
    ) {
    }

    public function update(MultimediaMediaLibraryEventDto $dto, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibraryEvent
    {
        $this->validator->validate($dto);

        $mediaLibraryMultimediaEvent = $dto->getEntity();

        $this->validator->validate($mediaLibraryMultimediaEvent);

        $this->upsertMultimediaMediaLibraryEvent->save($dto, $multimediaMediaLibrary);

        return $mediaLibraryMultimediaEvent;
    }
}