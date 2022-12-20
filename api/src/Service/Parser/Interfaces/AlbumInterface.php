<?php

namespace App\Service\Parser\Interfaces;

interface AlbumInterface
{
    public function getType(): ?string;

    public function getTitle(): string;

    public function getDescription(): ?string;

    public function getImage(): ?string;
}