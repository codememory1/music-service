<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class UnpublishMultimedia
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function process(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isPublished()) {
            throw MultimediaException::badUnpublish();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::UNPUBLISHED));

        return $multimedia;
    }
}