<?php

namespace App\Service\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Infrastructure\Validator\Validator;

class CreateAlbum
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertAlbum $upsertAlbum
    ) {
    }

    public function create(AlbumDto $dto, User $toUser): Album
    {
        $this->validator->validate($dto);

        $album = $dto->getEntity();

        $album->setUser($toUser);

        $this->upsertAlbum->save($dto, $album);

        return $album;
    }
}