<?php

namespace App\Service\TranslationKey;

use App\Dto\Transfer\TranslationKeyDto;
use App\Entity\TranslationKey;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

final class CreateTranslationKeyService
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(TranslationKeyDto $dto): TranslationKey
    {
        $this->validator->validate($dto);

        $translationKey = $dto->getEntity();

        $this->flusher->save($translationKey);

        return $translationKey;
    }
}