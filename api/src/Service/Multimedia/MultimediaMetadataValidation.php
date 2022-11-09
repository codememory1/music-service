<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Enum\PlatformSettingEnum;
use App\Exception\Http\InvalidException;
use App\Exception\Http\MultimediaException;
use App\Service\PlatformSetting;
use FFMpeg\FFProbe;
use FFMpeg\FFProbe\DataMapping\Stream;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class MultimediaMetadataValidation
{
    public function __construct(
        private readonly PlatformSetting $platformSetting
    ) {
    }

    public function initMultimedia(UploadedFile $file, Multimedia $multimedia): ?Stream
    {
        $FFProbe = FFProbe::create();

        if (false === $FFProbe->isValid($file->getRealPath())) {
            throw InvalidException::invalidMultimedia();
        }

        $streamCollection = $FFProbe->streams($file->getRealPath());

        if ($multimedia->isTrack()) {
            return $streamCollection->audios()->first();
        }

        if ($multimedia->isClip()) {
            return $streamCollection->videos()->first();
        }

        return null;
    }

    public function validateDuration(Multimedia $multimedia, Stream $stream): void
    {
        $maxDurationTrack = $this->platformSetting->get(PlatformSettingEnum::MULTIMEDIA_DURATION_TRACK_KEY);
        $maxDurationClip = $this->platformSetting->get(PlatformSettingEnum::MULTIMEDIA_DURATION_CLIP_KEY);

        $allowedDuration = match ($multimedia->getType()) {
            MultimediaTypeEnum::TRACK->name => $maxDurationTrack,
            MultimediaTypeEnum::CLIP->name => $maxDurationClip,
            default => null
        };

        if ($stream->get('duration') > $allowedDuration) {
            throw MultimediaException::badDuration(['duration' => $allowedDuration]);
        }
    }
}