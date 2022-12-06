<?php

namespace App\UseCase\Language;

use App\Entity\Language;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteLanguage
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(Language $language): Language
    {
        $this->flusher->remove($language);

        return $language;
    }
}