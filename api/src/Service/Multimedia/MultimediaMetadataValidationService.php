<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaTypeEnum;
use App\Enum\PlatformSettingEnum;
use App\Enum\PlatformSettingValueKeyEnum;
use App\Exception\Http\InvalidException;
use App\Exception\Http\MultimediaException;
use App\Service\PlatformSettingService;
use FFMpeg\FFProbe;
use FFMpeg\FFProbe\DataMapping\Stream;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MultimediaMetadataValidationService
{
    private PlatformSettingService $platformSetting;
    private Multimedia $multimedia;
    private ?Stream $stream = null;

    public function __construct(PlatformSettingService $platformSettingService)
    {
        $this->platformSetting = $platformSettingService;
    }

    public function initMultimedia(UploadedFile $file, Multimedia $multimedia): self
    {
        $FFProbe = FFProbe::create();
        $this->multimedia = $multimedia;

        if (false === $FFProbe->isValid($file->getRealPath())) {
            throw InvalidException::invalidMultimedia();
        }

        $streamCollection = $FFProbe->streams($file->getRealPath());

        if ($multimedia->isTrack()) {
            $this->stream = $streamCollection->audios()->first();
        }

        if ($multimedia->isClip()) {
            $this->stream = $streamCollection->videos()->first();
        }

        return $this;
    }

    public function validateDuration(): void
    {
        $this->platformSetting->saveToMemory(PlatformSettingEnum::MULTIMEDIA_DURATION);
        $allowedDuration = match ($this->multimedia->getType()) {
            MultimediaTypeEnum::TRACK->name => $this->platformSetting->getFromValue(PlatformSettingValueKeyEnum::MULTIMEDIA_DURATION_TRACK_KEY),
            MultimediaTypeEnum::CLIP->name => $this->platformSetting->getFromValue(PlatformSettingValueKeyEnum::MULTIMEDIA_DURATION_CLIP_KEY),
            default => null
        };

        if ($this->stream->get('duration') > $allowedDuration) {
            throw MultimediaException::badDuration($allowedDuration);
        }
    }
}