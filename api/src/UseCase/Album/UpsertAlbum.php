<?php

namespace App\UseCase\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;
use App\Service\Album\UpsertAlbumFiles;

final class UpsertAlbum
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly UpsertAlbumFiles $upsertAlbumFiles
    ) {
    }

    public function process(AlbumDto $dto, Album $album, User $owner): Album
    {
        $album->setUser($owner);
        $album->setImage($this->upsertAlbumFiles->uploadImage($dto->image, $album));

        $this->flusher->save($album);

        return $album;
    }
}