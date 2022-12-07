<?php

namespace App\Service\Multimedia\Subtitles;

use Captioning\Format\SubstationalphaFile;

final class SubstationAlphaSubtitleFile extends AbstractSubtitleFileFactory
{
    protected function getFormat(): string
    {
        return SubstationalphaFile::class;
    }
}