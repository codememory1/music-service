<?php

namespace App\Dto\Transfer;

use Codememory\Dto\Constraints as DC;
use App\Entity\User;
use App\Exception\Http\EntityNotFoundException;
use Codememory\Dto\DataTransfer;

final class MonetizationBranchDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\ToEntityList(User::class, 'id', unique: true, entityNotFoundCallback: 'throwArtistNotFound')]
    public array $ignoredArtists = [];

    public function throwArtistNotFound(mixed $value): array
    {
        throw EntityNotFoundException::user(['id' => $value]);
    }
}