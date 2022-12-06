<?php

namespace App\UseCase\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdateAlbum
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UpsertImage $upsertImage
    ) {
    }

    public function process(AlbumDto $dto, User $owner): Album
    {
        $this->validator->validate($dto);

        $album = $dto->getEntity();

        $album->setUser($owner);
        $album->setImage($this->upsertImage->process($dto, $album));

        $this->flusher->save($album);

        return $album;
    }
}