<?php

namespace App\Service\Multimedia\Subtitles;

use App\Service\Multimedia\Subtitles\Interfaces\MultimediaSubtitlesFileInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MultimediaSubtitles
{
    public const FORMATS = [
        'srt' => SubripSubtitleFile::class,
        'vtt' => WebvttSubtitleFile::class,
        'ass' => SubstationAlphaSubtitleFile::class,
        'sbv' => SBVSubtitleFile::class,
        'json' => JsonSubtitleFile::class
    ];

    public function open(UploadedFile $file): ?MultimediaSubtitlesFileInterface
    {
        $extension = $file->getClientOriginalExtension();

        if (array_key_exists($extension, self::FORMATS)) {
            return new (self::FORMATS[$extension])($file->getRealPath());
        }

        return null;
    }
}