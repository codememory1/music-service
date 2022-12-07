<?php

namespace App\Service\Multimedia\Subtitles;

use Captioning\Format\SubripFile;

final class SubripSubtitleFile extends AbstractSubtitleFileFactory
{
    protected function getFormat(): string
    {
        return SubripFile::class;
    }
}