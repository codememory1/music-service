<?php

namespace App\Service\Multimedia;

use App\Enum\MultimediaTypeEnum;
use FFMpeg\FFProbe;
use FFMpeg\FFProbe\DataMapping\Stream;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MultimediaStream
{
    public function createStreamByMultimediaType(UploadedFile $file, MultimediaTypeEnum $type): ?Stream
    {
        $FFProbe = FFProbe::create();

        if (false === $FFProbe->isValid($file->getRealPath())) {
            return null;
        }

        $collection = $FFProbe->streams($file->getRealPath());

        return match ($type) {
            MultimediaTypeEnum::TRACK => $collection->audios()->first(),
            MultimediaTypeEnum::CLIP => $collection->videos()->first()
        };
    }

    public function getDuration(Stream $stream): float
    {
        return $stream->get('duration');
    }
}