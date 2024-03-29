<?php

namespace App\UseCase\Playlist\Directory;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\PlaylistDirectory;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class UpdatePlaylistDirectory
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(PlaylistDirectoryDto $dto): PlaylistDirectory
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}