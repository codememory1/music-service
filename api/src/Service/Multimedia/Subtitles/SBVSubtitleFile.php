<?php

namespace App\Service\Multimedia\Subtitles;

use Captioning\Format\SBVFile;

final class SBVSubtitleFile extends AbstractSubtitleFileFactory
{
    protected function getFormat(): string
    {
        return SBVFile::class;
    }
}