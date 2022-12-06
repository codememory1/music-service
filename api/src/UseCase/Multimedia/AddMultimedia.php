<?php

namespace App\UseCase\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
use App\Entity\MultimediaStatistic;
use App\Entity\User;
use App\Infrastructure\Validator\Validator;
use App\Service\Multimedia\UpsertMultimedia;

final class AddMultimedia
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertMultimedia $upsertMultimedia
    ) {
    }

    public function process(MultimediaDto $dto, User $owner): Multimedia
    {
        $this->validator->validate($dto);

        $multimedia = $dto->getEntity();

        $multimedia->setUser($owner);
        $multimedia->setDraftStatus();
        $multimedia->setStatistic(new MultimediaStatistic());

        $this->upsertMultimedia->save($dto, $multimedia);

        return $multimedia;
    }
}