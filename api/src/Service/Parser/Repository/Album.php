<?php

namespace App\Service\Parser\Repository;

class Album
{
    private ?string $name = null;
    private ?string $imageLink = null;
    private array $multimedia = [];

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    /**
     * @param array<int, Multimedia> $multimedia
     */
    public function setMultimedia(array $multimedia): self
    {
        $this->multimedia = $multimedia;

        return $this;
    }

    /**
     * @return array<int, Multimedia>
     */
    public function getMultimedia(): array
    {
        return $this->multimedia;
    }

    public function addMultimedia(Multimedia $multimedia): self
    {
        $this->multimedia[] = $multimedia;

        return $this;
    }
}