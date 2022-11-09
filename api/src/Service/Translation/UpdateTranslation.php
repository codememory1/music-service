<?php

namespace App\Service\Translation;

use App\Dto\Transfer\TranslationDto;
use App\Entity\Translation;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateTranslation
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(TranslationDto $dto): Translation
    {
        $this->validator->validate($dto);

        $translation = $dto->getEntity();

        $translation->getTranslationKey()->setKey($dto->translationKey);

        $this->flusher->save();

        return $translation;
    }
}