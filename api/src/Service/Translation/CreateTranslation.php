<?php

namespace App\Service\Translation;

use App\Dto\Transfer\TranslationDto;
use App\Dto\Transformer\TranslationKeyTransformer;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;
use App\Service\TranslationKey\CreateTranslationKeyService;

final class CreateTranslation
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator,
        private readonly TranslationKeyTransformer $translationKeyTransformer,
        private readonly CreateTranslationKeyService $createTranslationKey
    ) {
    }

    public function create(TranslationDto $dto): Translation
    {
        $this->validator->validate($dto);

        $translation = $dto->getEntity();

        $translation->setTranslationKey($this->createTranslationKey($dto));

        $this->flusher->save($translation);

        return $translation;
    }

    private function createTranslationKey(TranslationDto $dto): TranslationKey
    {
        $translationKeyDto = $this->translationKeyTransformer->transformFromArray([
            'key' => $dto->translationKey
        ]);

        return $this->createTranslationKey->create($translationKeyDto);
    }
}