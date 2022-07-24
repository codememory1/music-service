<?php

namespace App\EventListener\SaveMultimedia\Before;

use App\Enum\MultimediaMimeTypeEnum;
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

        if ($event->multimedia->isTrack()) {
            $this->trackType($multimediaMimeType);
        } elseif ($event->multimedia->isClip()) {
            $this->clipType($multimediaMimeType);
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