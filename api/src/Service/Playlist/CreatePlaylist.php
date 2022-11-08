<?php

namespace App\Service\Playlist;

use App\Dto\Transfer\PlaylistDto;
use App\Entity\Playlist;
use App\Entity\User;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Validator\Validator;

class CreatePlaylist
{
    public function __construct(
        private readonly Validator $validator,
        private readonly UpsertPlaylist $upsertPlaylist
    ) {
    }

    public function create(PlaylistDto $dto, User $owner): Playlist
    {
        $this->validator->validate($dto);

        if (null === $owner->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $playlist = $dto->getEntity();

        $owner->getMediaLibrary()->addPlaylist($playlist);

        $this->upsertPlaylist->save($dto, $playlist);

        return $playlist;
    }
}