<?php

namespace App\Service\Parser\Interfaces;

use DateTimeInterface;

interface ArtistInfoInterface
{
    public function getPseudonym(): string;

    public function getPhoto(): ?string;

    public function getDateBirth(): DateTimeInterface;

    public function getEmail(): string;

    /**
     * @return array<int, AlbumInterface>
     */
    public function getAlbums(): array;
}