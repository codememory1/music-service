<?php

namespace App\Service\Translator\Interfaces;

use App\Entity\Language;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface TranslatorInterface
{
    public function setLanguage(Language $language): self;

    public function setText(string $text): self;

    public function send(): void;

    public function getResponse(): ?ResponseInterface;

    public function getTranslation(): string;
}