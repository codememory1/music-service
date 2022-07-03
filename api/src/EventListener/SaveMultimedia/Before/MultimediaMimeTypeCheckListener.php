<?php

namespace App\EventListener\SaveMultimedia\Before;

use App\Enum\MultimediaMimeTypeEnum;
use App\Enum\MultimediaTypeEnum;
use App\Event\SaveMultimediaEvent;
use App\Rest\Http\Exceptions\MultimediaException;

/**
 * Class MultimediaMimeTypeCheckListener.
 *
 * @package App\EventListener\SaveMultimedia\Before
 *
 * @author  Codememory
 */
class MultimediaMimeTypeCheckListener
{
    public function onBeforeSaveMultimedia(SaveMultimediaEvent $event): void
    {
        $multimediaMimeType = $event->multimediaDTO->multimedia->getMimeType();

        switch ($event->multimedia->getType()) {
            case MultimediaTypeEnum::TRACK->name:
                $this->trackType($multimediaMimeType);
                break;
            case MultimediaTypeEnum::CLIP->name:
                $this->clipType($multimediaMimeType);
                break;
        }
    }

    private function trackType(string $mimeType): void
    {
        if (false === in_array($mimeType, MultimediaMimeTypeEnum::trackMimeTypes(), true)) {
            throw MultimediaException::badTrackMimeType();
        }
    }

    private function clipType(string $mimeType): void
    {
        if (false === in_array($mimeType, MultimediaMimeTypeEnum::clipMimeTypes(), true)) {
            throw MultimediaException::badClipMimeType();
        }
    }
}