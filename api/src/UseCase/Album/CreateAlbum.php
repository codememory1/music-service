<?php

namespace App\UseCase\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Infrastructure\Validator\Validator;

final class CreateAlbum
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertAlbum $upsertAlbum
    ) {
    }

    public function process(AlbumDto $dto, User $owner): Album
    {
        $this->validator->validate($dto);

        return $this->upsertAlbum->process($dto, $dto->getEntity(), $owner);
    }
}