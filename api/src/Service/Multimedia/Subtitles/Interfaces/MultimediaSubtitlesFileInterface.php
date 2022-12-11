<?php

namespace App\Service\Multimedia\Subtitles\Interfaces;

use Captioning\File;

interface MultimediaSubtitlesFileInterface
{
    public function getFile(): ?File;

    public function isValidated(): bool;
}