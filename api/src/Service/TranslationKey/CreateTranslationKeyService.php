<?php

namespace App\Service\TranslationKey;

use App\Dto\Transfer\TranslationKeyDto;
use App\Entity\TranslationKey;
use App\Service\AbstractService;

class CreateTranslationKeyService extends AbstractService
{
    public function create(TranslationKeyDto $translationKeyDto): TranslationKey
    {
        $this->validate($translationKeyDto);

        $translationKey = $translationKeyDto->getEntity();

        $this->flusherService->save($translationKey);

        return $translationKey;
    }
}