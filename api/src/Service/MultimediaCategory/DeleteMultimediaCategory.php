<?php

namespace App\Service\MultimediaCategory;

use App\Entity\MultimediaCategory;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaCategory
{
    public function __construct(
        private readonly Flusher $flusher,
    ) {
    }

    public function delete(MultimediaCategory $multimediaCategory): MultimediaCategory
    {
        $this->flusher->remove($multimediaCategory);

        return $multimediaCategory;
    }
}