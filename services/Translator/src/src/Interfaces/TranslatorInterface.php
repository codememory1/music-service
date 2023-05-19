<?php

namespace App\Interfaces;

use App\Entity\Language;

interface TranslatorInterface
{
    public function setFromLanguage(Language $language): self;

    public function setToLanguage(Language $language): self;

    public function setText(string $text): self;

    public function translate(): ?string;
}