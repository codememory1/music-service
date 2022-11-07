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

    public function create(AlbumDto $albumDto, User $toUser): Album
    {
        $this->validator->validate($albumDto);

        $album = $albumDto->getEntity();

        $album->setUser($toUser);

        $this->upsertAlbum->save($albumDto, $album);

        return $album;
    }
}