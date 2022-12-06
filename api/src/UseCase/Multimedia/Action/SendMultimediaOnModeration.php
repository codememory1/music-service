<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SendMultimediaOnModeration
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function process(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isDraft()) {
            throw MultimediaException::badSendOnModeration();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::MODERATION));

        return $multimedia;
    }
}