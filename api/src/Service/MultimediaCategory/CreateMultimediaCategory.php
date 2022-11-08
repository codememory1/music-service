<?php

namespace App\Service\MultimediaCategory;

use App\Dto\Transfer\MultimediaCategoryDto;
use App\Entity\MultimediaCategory;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

class CreateMultimediaCategory
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(MultimediaCategoryDto $dto): MultimediaCategory
    {
        $this->validator->validate($dto);

        $multimediaCategory = $dto->getEntity();

        $this->flusher->save($multimediaCategory);

        return $multimediaCategory;
    }
}