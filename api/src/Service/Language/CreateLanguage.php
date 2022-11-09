<?php

namespace App\Service\Language;

use App\Dto\Transfer\LanguageDto;
use App\Entity\Language;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class CreateLanguage
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(LanguageDto $dto): Language
    {
        $this->validator->validate($dto);

        $language = $dto->getEntity();

        $this->validator->validate($language);

        $this->flusher->save($language);

        return $language;
    }
}