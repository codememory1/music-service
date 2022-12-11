<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class MultimediaCancelAppeal
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function appeal(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isAppeal()) {
            throw MultimediaException::badAppealCanceled();
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL_CANCELED));

        return $multimedia;
    }
}