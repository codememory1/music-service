<?php

namespace App\Service\MultimediaCategory;

use App\Entity\MultimediaCategory;
use App\Service\FlusherService;

class DeleteMultimediaCategory
{
    public function __construct(
        private readonly FlusherService $flusher,
    ) {
    }

    public function delete(MultimediaCategory $multimediaCategory): MultimediaCategory
    {
        $this->flusher->remove($multimediaCategory);

        return $multimediaCategory;
    }
}