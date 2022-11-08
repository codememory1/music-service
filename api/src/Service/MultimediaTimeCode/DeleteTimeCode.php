<?php

namespace App\Service\MultimediaTimeCode;

use App\Entity\MultimediaTimeCode;
use App\Service\FlusherService;

final class DeleteTimeCode
{
    public function __construct(
        private readonly FlusherService $flusher
    ) {
    }

    public function delete(MultimediaTimeCode $multimediaTimeCode): MultimediaTimeCode
    {
        $this->flusher->remove($multimediaTimeCode);

        return $multimediaTimeCode;
    }
}