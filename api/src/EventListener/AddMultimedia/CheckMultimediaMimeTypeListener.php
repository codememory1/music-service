<?php

namespace App\EventListener\AddMultimedia;

use App\Enum\MultimediaMimeTypeEnum;
use App\Enum\MultimediaTypeEnum;
use App\Event\AddMultimediaEvent;
use App\Rest\Http\Exceptions\MultimediaException;

/**
 * Class CheckMultimediaMimeTypeListener.
 *
 * @package App\EventListener\AddMultimedia
 *
 * @author  Codememory
 */
class CheckMultimediaMimeTypeListener
{
    /**
     * @param AddMultimediaEvent $event
     *
     * @return void
     */
    public function onBeforeAddMultimedia(AddMultimediaEvent $event): void
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

    /**
     * @param string $mimeType
     *
     * @return void
     */
    private function trackType(string $mimeType): void
    {
        if (false === in_array($mimeType, MultimediaMimeTypeEnum::trackMimeTypes(), true)) {
            throw MultimediaException::badTrackMimeType();
        }
    }

    /**
     * @param string $mimeType
     *
     * @return void
     */
    private function clipType(string $mimeType): void
    {
        if (false === in_array($mimeType, MultimediaMimeTypeEnum::clipMimeTypes(), true)) {
            throw MultimediaException::badClipMimeType();
        }
    }
}