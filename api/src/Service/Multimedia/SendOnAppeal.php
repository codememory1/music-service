<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SendOnAppeal
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function sendOnAppeal(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isUnpublished() && false === $multimedia->isAppealCanceled()) {
            throw MultimediaException::badSendOnAppeal(['status' => MultimediaStatusEnum::getValueByName($multimedia->getStatus())]);
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL));

        return $multimedia;
    }
}