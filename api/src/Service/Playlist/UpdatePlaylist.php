<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Infrastructure\Validator\Validator;

class UpdatePlaylist
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertPlaylist $upsertPlaylist
    ) {
    }

    public function update(PlaylistDto $dto): Playlist
    {
        $this->validator->validate($dto);

        $playlist = $dto->getEntity();

        $this->upsertPlaylist->save($dto, $playlist);

        return $playlist;
    }
}