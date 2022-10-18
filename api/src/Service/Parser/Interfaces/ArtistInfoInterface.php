<?php

namespace App\Service\Parser\Interfaces;

use DateTimeInterface;

interface ArtistInfoInterface
{
    public function getId(): ?int;

    public function setId(int $id): self;
    
    public function getPseudonym(): string;
    
    public function setPseudonym(string $pseudonym): self;

    public function getPhoto(): ?string;
    
    public function setPhoto(string $photoUrl): self;

    public function getDateBirth(): ?DateTimeInterface;

    public function setDateBirth(DateTimeInterface $dateBirth): self;

    public function getEmail(): ?string;
    
    public function setEmail(string $email): self;
}