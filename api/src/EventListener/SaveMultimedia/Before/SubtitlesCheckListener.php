<?php

namespace App\EventListener\SaveMultimedia\Before;

use App\Event\SaveMultimediaEvent;
use App\Rest\Http\Exceptions\InvalidException;
use Captioning\Format\SubripFile;
use Exception;

/**
 * Class SubtitlesCheckListener.
 *
 * @package App\EventListener\SaveMultimedia\Before
 *
 * @author  Codememory
 */
class SubtitlesCheckListener
{
    /**
     * @param SaveMultimediaEvent $event
     *
     * @return void
     */
    public function onBeforeSaveMultimedia(SaveMultimediaEvent $event): void
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