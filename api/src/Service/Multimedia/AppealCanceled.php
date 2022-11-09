<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AppealCanceled
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