<?php

namespace App\Service\PlaylistDirectory;

use App\Dto\Transfer\PlaylistDirectoryDto;
use App\Entity\PlaylistDirectory;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

final class UpdatePlaylistDirectory
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function update(PlaylistDirectoryDto $dto): PlaylistDirectory
    {
        $this->validator->validate($dto);

        $this->flusher->save();

        return $dto->getEntity();
    }
}