<?php

namespace App\Service\Language;

use App\Entity\Language;
use App\Service\FlusherService;

class DeleteLanguage
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(Language $language): Language
    {
        $this->flusher->remove($language);

        return $language;
    }
}