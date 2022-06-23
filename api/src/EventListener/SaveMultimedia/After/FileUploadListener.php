<?php

namespace App\EventListener\SaveMultimedia\After;

use App\Event\SaveMultimediaEvent;
use App\Message\MultimediaUploadFileMessage;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Class FileUploadListener.
 *
 * @package App\EventListener\SaveMultimedia\After
 *
 * @author  Codememory
 */
class FileUploadListener
{
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    /**
     * @param MessageBusInterface $bus
     */
    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    /**
     * @param SaveMultimediaEvent $event
     *
     * @return void
     */
    public function onAfterSaveMultimedia(SaveMultimediaEvent $event): void
    {
        $multimediaFile = $event->multimediaDTO->multimedia;
        $subtitlesFile = $event->multimediaDTO->subtitles;
        $imageFile = $event->multimediaDTO->image;

        $multimediaUploadFileMessage = new MultimediaUploadFileMessage($event->multimedia->getId());

        $multimediaUploadFileMessage->setMultimediaFile(
            $multimediaFile->getRealPath(),
            $multimediaFile->getMimeType()
        );
        $multimediaUploadFileMessage->setSubtitlesFile(
            $subtitlesFile?->getRealPath(),
            $subtitlesFile?->getClientMimeType()
        );
        $multimediaUploadFileMessage->setImage(
            $imageFile->getRealPath(),
            $imageFile->getMimeType()
        );

        $this->bus->dispatch($multimediaUploadFileMessage);
    }
}