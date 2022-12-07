<?php

namespace App\UseCase\MultimediaCategory;

use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\MultimediaCategory;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class CreateMultimediaCategory
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(MultimediaCategoryDto $dto): MultimediaCategory
    {
        $this->validator->validate($dto);

        $multimediaCategory = $dto->getEntity();

        $this->flusher->save($multimediaCategory);

        return $multimediaCategory;
    }
}