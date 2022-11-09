<?php

namespace App\Service\Multimedia;

use App\Dto\Transfer\MultimediaDto;
use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Exception\Http\MultimediaException;
use App\Infrastructure\Validator\Validator;

final class UpdateMultimedia
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertMultimedia $upsertMultimedia
    ) {
    }

    public function update(MultimediaDto $dto): Multimedia
    {
        $this->validator->validate($dto);

        $multimedia = $dto->getEntity();

        if ($multimedia->isPublished() || $multimedia->isModeration() || $multimedia->isAppeal()) {
            throw MultimediaException::badUpdateInStatus(['status' => MultimediaStatusEnum::getValueByName($multimedia->getStatus())]);
        }

        $this->upsertMultimedia->save($dto, $multimedia);

        return $multimedia;
    }
}