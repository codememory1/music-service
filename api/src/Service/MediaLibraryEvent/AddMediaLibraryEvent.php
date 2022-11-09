<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Validator\Validator;

final class AddMediaLibraryEvent
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertMediaLibrary $upsertMediaLibrary
    ) {
    }

    public function add(MediaLibraryEventDto $dto, MediaLibrary $mediaLibrary): MediaLibraryEvent
    {
        $this->validator->validate($dto);

        $mediaLibraryEvent = $dto->getEntity();

        $mediaLibraryEvent->setMediaLibrary($mediaLibrary);

        $this->validator->validate($mediaLibraryEvent);

        $this->upsertMediaLibrary->save($dto, $mediaLibrary, $mediaLibraryEvent);

        return $mediaLibraryEvent;
    }
}