<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Dto\Transfer\MultimediaMediaLibraryEventDto;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\MultimediaMediaLibraryEvent;
use App\Infrastructure\Validator\Validator;

final class AddMultimediaMediaLibraryEvent
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertMultimediaMediaLibraryEvent $upsertMultimediaMediaLibrary
    ) {
    }

    public function add(MultimediaMediaLibraryEventDto $dto, MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibraryEvent
    {
        $this->validator->validate($dto);

        $multimediaMediaLibraryEvent = $dto->getEntity();

        $multimediaMediaLibraryEvent->setMultimediaMediaLibrary($multimediaMediaLibrary);

        $this->validator->validate($multimediaMediaLibrary);

        $this->upsertMultimediaMediaLibrary->save($dto, $multimediaMediaLibrary);

        return $multimediaMediaLibraryEvent;
    }
}