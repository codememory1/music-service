<?php

namespace App\UseCase\MediaLibrary;

use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\MediaLibrary;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateMediaLibrary
{
    public function __construct(
        private readonly Validator $validator,
        private readonly Flusher $flusher
    ) {
    }

    public function process(MediaLibraryDto $dto): MediaLibrary
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}