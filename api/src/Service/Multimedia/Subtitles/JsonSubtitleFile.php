<?php

namespace App\Service\Multimedia\Subtitles;

use Captioning\Format\JsonFile;

final class JsonSubtitleFile extends AbstractSubtitleFileFactory
{
    protected function getFormat(): string
    {
        return JsonFile::class;
    }
}