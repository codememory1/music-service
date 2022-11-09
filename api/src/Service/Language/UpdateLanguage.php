<?php

namespace App\Service\Language;

use App\Dto\Transfer\LanguageDto;
use App\Entity\Language;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateLanguage
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(LanguageDto $dto): Language
    {
        $this->validator->validate($dto);

        $language = $dto->getEntity();

        $this->validator->validate($language);

        $this->flusher->save();

        return $language;
    }
}