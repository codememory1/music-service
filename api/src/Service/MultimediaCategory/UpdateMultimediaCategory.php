<?php

namespace App\Service\MultimediaCategory;

use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\MultimediaCategory;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

class UpdateMultimediaCategory
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(MultimediaCategoryDto $dto): MultimediaCategory
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}