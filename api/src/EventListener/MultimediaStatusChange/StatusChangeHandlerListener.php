<?php

namespace App\EventListener\MultimediaStatusChange;

use App\Entity\MultimediaQueue;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use App\Service\FlusherService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('app.multimedia.status-change', 'onMultimediaStatusChange')]
final class StatusChangeHandlerListener
{
    private FlusherService $flusherService;

    public function __construct(FlusherService $flusherService)
    {
        $this->flusherService = $flusherService;
    }

    public function onMultimediaStatusChange(MultimediaStatusChangeEvent $event): void
    {
        match ($event->onStatus) {
            MultimediaStatusEnum::PUBLISHED => $this->publishStatusHandler($event),
            MultimediaStatusEnum::UNPUBLISHED => $this->unpublishStatusHandler($event),
            MultimediaStatusEnum::MODERATION => $this->moderationStatusHandler($event),
            MultimediaStatusEnum::APPEAL,
            MultimediaStatusEnum::APPEAL_CANCELED => $this->changeStatus($event),
        };

        $this->flusherService->save();
    }

    public function moderationStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);
        $event->multimedia->setQueue(new MultimediaQueue());
    }

    private function publishStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);

        if (null !== $event->multimedia->getQueue()) {
            $this->flusherService->addRemove($event->multimedia->getQueue());
        }
    }

    private function unpublishStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);

        if (null !== $event->multimedia->getQueue()) {
            $this->flusherService->addRemove($event->multimedia->getQueue());
        }
    }

    private function changeStatus(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);
    }
}