<?php

namespace App\Service\Multimedia;

use App\Enum\MultimediaMimeTypeEnum;
use App\Service\Multimedia\Subtitles\MultimediaSubtitles;
use FFMpeg\FFProbe\DataMapping\Stream;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MultimediaValidator
{
    public function __construct(
        private readonly MultimediaStream $multimediaStream,
        private readonly MultimediaSubtitles $multimediaSubtitles
    ) {
    }

    public function isValidatedTrackMimeType(UploadedFile $file): bool
    {
        return in_array($file->getMimeType(), MultimediaMimeTypeEnum::trackMimeTypes(), true);
    }

    public function isValidatedClipMimeType(UploadedFile $file): bool
    {
        return in_array($file, MultimediaMimeTypeEnum::clipMimeTypes(), true);
    }

    public function isValidatedTrackDuration(Stream $stream, float $max): bool
    {
        return $this->multimediaStream->getDuration($stream) > $max;
    }

    public function isValidatedClipDuration(Stream $stream, float $max): bool
    {
        return $this->multimediaStream->getDuration($stream) > $max;
    }

    public function isValidatedSubtitles(UploadedFile $file): bool
    {
        return $this->multimediaSubtitles->open($file)->isValidated();
    }
}