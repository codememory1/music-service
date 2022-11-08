<?php

namespace App\Service\PlaylistDirectory;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\Playlist;
use App\Entity\PlaylistDirectory;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

final class CreatePlaylistDirectory
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function create(PlaylistDirectoryDto $dto, Playlist $playlist): PlaylistDirectory
    {
        $this->validator->validate($dto);

        $playlistDirectory = $dto->getEntity();

        $playlistDirectory->setPlaylist($playlist);

        $this->flusher->save($playlistDirectory);

        return $playlistDirectory;
    }
}