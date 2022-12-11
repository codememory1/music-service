<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Exception\Http\MultimediaException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class SendMultimediaOnAppeal
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function process(Multimedia $multimedia): Multimedia
    {
        if (false === $multimedia->isUnpublished() && false === $multimedia->isAppealCanceled()) {
            throw MultimediaException::badSendOnAppeal(['status' => MultimediaStatusEnum::getValueByName($multimedia->getStatus())]);
        }

        $this->eventDispatcher->dispatch(new MultimediaStatusChangeEvent($multimedia, MultimediaStatusEnum::APPEAL));

        return $multimedia;
    }
}