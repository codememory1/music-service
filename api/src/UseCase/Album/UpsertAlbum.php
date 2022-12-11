<?php

namespace App\UseCase\Album;

use App\Dto\Transfer\AlbumDto;
use App\Entity\Album;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;
use App\Service\Album\UpsertAlbumFile;

final class UpsertAlbum
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly UpsertAlbumFile $upsertAlbumFile
    ) {
    }

    public function process(AlbumDto $dto, Album $album, User $owner): Album
    {
        $album->setUser($owner);
        $album->setImage($this->upsertAlbumFile->uploadImage($dto->image, $album));

        $this->flusher->save($album);

        return $album;
    }
}