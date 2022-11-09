<?php

namespace App\Service\MediaLibraryEvent;

use App\Dto\Transfer\MediaLibraryEventDto;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Infrastructure\Validator\Validator;

final class UpdateMediaLibraryEvent
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertMediaLibrary $upsertMediaLibrary
    ) {
    }

    public function update(MediaLibraryEventDto $dto, MediaLibrary $mediaLibrary): MediaLibraryEvent
    {
        $this->validator->validate($dto);

        $mediaLibraryEvent = $dto->getEntity();

        $this->validator->validate($mediaLibraryEvent);

        $this->upsertMediaLibrary->save($dto, $mediaLibrary);

        return $mediaLibraryEvent;
    }
}