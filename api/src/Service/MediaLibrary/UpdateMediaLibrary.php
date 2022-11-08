<?php

namespace App\Service\MediaLibrary;

use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\MediaLibrary;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

class UpdateMediaLibrary
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(MediaLibraryDto $dto): MediaLibrary
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}