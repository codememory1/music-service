<?php

namespace App\Service\Parser\Repository;

use DateTimeInterface;

class Artist
{
    private ?string $pseudonym = null;
    private array $photos = [];
    private ?DateTimeInterface $dateBirth = null;
    private ?string $biography = null;
    private array $albums = [];

    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }

    public function setPseudonym(string $pseudonym): self
    {
        $this->pseudonym = $pseudonym;

        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(?string $biography): self
    {
        $this->biography = $biography;

        return $this;
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }

    public function addPhoto(string $link): self
    {
        $this->photos[] = $link;

        return $this;
    }

    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }

    public function setDateBirth(DateTimeInterface $dateBirth): self
    {
        $this->dateBirth = $dateBirth;

        return $this;
    }

    /**
     * @param array<int, Album> $albums
     */
    public function setAlbums(array $albums): self
    {
        $this->albums = $albums;

        return $this;
    }

    /**
     * @return array<int, Album>
     */
    public function getAlbums(): array
    {
        return $this->albums;
    }
}