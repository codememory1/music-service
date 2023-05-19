<?php

namespace App\ValueObject;

final readonly class Translation
{
    public function __construct(
        private string $text,
        private string $detectedLanguage
    ) {
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getDetectedLanguage(): string
    {
        return $this->detectedLanguage;
    }
}