<?php

namespace App\UseCase\MediaLibrary\Multimedia;

use App\Dto\Transfer\MultimediaMediaLibraryDto;
use App\Entity\MultimediaMediaLibrary;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\MultimediaMediaLibrary\UpsertMultimediaMediaLibraryFile;

final class UpdateMultimediaMediaLibrary
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UpsertMultimediaMediaLibraryFile $upsertMultimediaMediaLibraryFile
    ) {
    }

    public function process(MultimediaMediaLibraryDto $dto): MultimediaMediaLibrary
    {
        $this->validator->validate($dto);

        $multimediaMediaLibrary = $dto->getEntity();

        $multimediaMediaLibrary->setImage($this->upsertMultimediaMediaLibraryFile->uploadImage($dto->image, $multimediaMediaLibrary));

        $this->flusher->save();

        return $multimediaMediaLibrary;
    }
}