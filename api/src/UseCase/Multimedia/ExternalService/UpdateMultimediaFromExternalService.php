<?php

namespace App\UseCase\Multimedia\ExternalService;

use App\Dto\Transfer\UpdateMultimediaExternalServiceDto;
use App\Entity\MultimediaExternalService;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateMultimediaFromExternalService
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(UpdateMultimediaExternalServiceDto $dto): MultimediaExternalService
    {
        $this->validator->validate($dto);

        $multimediaExternalService = $dto->getEntity();

        $this->flusher->save();

        return $multimediaExternalService;
    }
}