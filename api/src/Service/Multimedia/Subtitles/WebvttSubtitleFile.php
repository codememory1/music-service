<?php

namespace App\Service\Multimedia\Subtitles;

use Captioning\Format\WebvttFile;

final class WebvttSubtitleFile extends AbstractSubtitleFileFactory
{
    protected function getFormat(): string
    {
        return WebvttFile::class;
    }
}