<?php

namespace App\Service\Translation;

use App\Dto\Transfer\DeleteTranslationDto;
use App\Entity\Translation;
use App\Service\FlusherService;

final class DeleteTranslation
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(DeleteTranslationDto $dto, Translation $translation): Translation
    {
        $this->flusher->addRemove($translation);

        if ($dto->deleteKey) {
            $this->flusher->addRemove($translation->getTranslationKey());
        }

        $this->flusher->save();

        return $translation;
    }
}