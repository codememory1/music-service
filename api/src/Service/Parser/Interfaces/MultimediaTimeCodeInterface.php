<?php

namespace App\Service\Parser\Interfaces;

interface MultimediaTimeCodeInterface
{
    public function getFromTime(): float;

    public function setFromTime(float $time): self;

    public function getToTime(): float;

    public function setToTime(float $time): self;

    public function getTitle(): string;

    public function setTitle(string $title): self;
}