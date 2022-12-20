<?php

namespace App\UseCase\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\Playlist\UpsertPlaylistFile;

final class UpdatePlaylist
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UpsertPlaylistFile $upsertPlaylistFile
    ) {
    }

    public function process(PlaylistDto $dto): Playlist
    {
        $this->validator->validate($dto);

        $playlist = $dto->getEntity();

        if (null !== $dto->image) {
            $playlist->setImage($this->upsertPlaylistFile->uploadImage($dto->image, $playlist));
        }

        $this->flusher->save();

        return $playlist;
    }
}