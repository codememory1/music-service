<?php

namespace App\UseCase\Playlist\Directory;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class CreatePlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(PlaylistDirectoryDto $dto, Playlist $playlist): PlaylistDirectory
    {
        $this->validator->validate($dto);

        $playlistDirectory = $dto->getEntity();

        $playlistDirectory->setPlaylist($playlist);

        $this->flusher->save($playlistDirectory);

        return $playlistDirectory;
    }
}