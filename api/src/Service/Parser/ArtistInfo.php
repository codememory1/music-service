<?php

namespace App\Service\Parser;

use App\Service\Parser\Interfaces\ArtistInfoInterface;
use DateTimeInterface;

class ArtistInfo implements ArtistInfoInterface
{
    public function getPseudonym(): string
    {
        // TODO: Implement getPseudonym() method.
    }

    public function getPhoto(): ?string
    {
        // TODO: Implement getPhoto() method.
    }

    public function getDateBirth(): DateTimeInterface
    {
        // TODO: Implement getDateBirth() method.
    }

    public function getEmail(): string
    {
        // TODO: Implement getEmail() method.
    }

    /**
     * @inheritDoc
     */
    public function getAlbums(): array
    {
        // TODO: Implement getAlbums() method.
    }
}