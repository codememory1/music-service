<?php

namespace App\Service\MultimediaTimeCode;

use App\Entity\MultimediaTimeCode;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteTimeCode
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function delete(MultimediaTimeCode $multimediaTimeCode): MultimediaTimeCode
    {
        $this->flusher->remove($multimediaTimeCode);

        return $multimediaTimeCode;
    }
}