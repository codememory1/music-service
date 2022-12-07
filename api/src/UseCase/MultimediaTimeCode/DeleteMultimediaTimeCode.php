<?php

namespace App\UseCase\MultimediaTimeCode;

use App\Entity\MultimediaTimeCode;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaTimeCode
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaTimeCode $multimediaTimeCode): MultimediaTimeCode
    {
        $this->flusher->remove($multimediaTimeCode);

        return $multimediaTimeCode;
    }
}