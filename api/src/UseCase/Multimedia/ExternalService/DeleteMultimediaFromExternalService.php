<?php

namespace App\UseCase\Multimedia\ExternalService;

use App\Entity\MultimediaExternalService;
use App\Infrastructure\Doctrine\Flusher;

final class DeleteMultimediaFromExternalService
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function process(MultimediaExternalService $multimediaExternalService): MultimediaExternalService
    {
        $this->flusher->remove($multimediaExternalService);

        return $multimediaExternalService;
    }
}