<?php

namespace App\EventListener\AddMultimedia;

use App\Event\AddMultimediaEvent;
use App\Rest\Http\Exceptions\InvalidException;
use Captioning\Format\SubripFile;
use Exception;

/**
 * Class SubtitleCheckListener.
 *
 * @package App\EventListener\AddMultimedia
 *
 * @author  Codememory
 */
class SubtitleCheckListener
{
    /**
     * @param AddMultimediaEvent $event
     *
     * @return void
     */
    public function onBeforeAddMultimedia(AddMultimediaEvent $event): void
    {
        $subtitlesFile = $event->multimediaDTO->subtitles;

        if (null !== $subtitlesFile) {
            try {
                new SubripFile($subtitlesFile->getRealPath());
            } catch (Exception) {
                throw InvalidException::invalidSubtitles();
            }
        }
    }
}