<?php

namespace App\UseCase\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Entity\User;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;
use App\Service\Playlist\UpsertPlaylistFile;

final class CreatePlaylist
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator,
        private readonly UpsertPlaylistFile $upsertPlaylistFile
    ) {
    }

    public function process(PlaylistDto $dto, User $owner): Playlist
    {
        $this->validator->validate($dto);

        if (null === $owner->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $playlist = $dto->getEntity();

        $playlist->setMediaLibrary($owner->getMediaLibrary());

        if (null !== $dto->image) {
            $playlist->setImage($this->upsertPlaylistFile->uploadImage($dto->image, $playlist));
        }

        $this->flusher->save($playlist);

        return $playlist;
    }
}