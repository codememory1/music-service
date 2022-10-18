<?php

namespace App\Service\Parser\Repository;

use App\Service\Parser\Interfaces\ArtistInfoInterface;
use DateTimeInterface;

class Artist implements ArtistInfoInterface
{
    private ?int $id = null;
    private ?string $pseudonym = null;
    private ?string $photo = null;
    private ?DateTimeInterface $dateBirth = null;
    private ?string $email = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function setId(int $id): self
    {
        $this->id = $id;
        
        return $this;
    }
    
    public function getPseudonym(): string
    {
        return $this->pseudonym;
    }
    
    public function setPseudonym(string $pseudonym): ArtistInfoInterface
    {
        $this->pseudonym = $pseudonym;
        
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }
    
    public function setPhoto(string $photoUrl): ArtistInfoInterface
    {
        $this->photo = $photoUrl;
        
        return $this;
    }

    public function getDateBirth(): ?DateTimeInterface
    {
        return $this->dateBirth;
    }
    
    public function setDateBirth(DateTimeInterface $dateBirth): ArtistInfoInterface
    {
        $this->dateBirth = $dateBirth;
        
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): ArtistInfoInterface
    {
        $this->email = $email;
        
        return $this;
    }
}