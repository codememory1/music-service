<?php

namespace App\Service\Parser\Interfaces;

interface SubtitlesInterface
{
    public function getFromTime(): float;

    public function setFromTime(float $time): self;

    public function getToTime(): float;

    public function setToTime(float $time): self;

    public function getText(): string;

    public function setText(string $text): self;
}