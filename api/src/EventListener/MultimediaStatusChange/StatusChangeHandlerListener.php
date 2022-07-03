<?php

namespace App\EventListener\MultimediaStatusChange;

use App\Entity\MultimediaQueue;
use App\Enum\MultimediaStatusEnum;
use App\Event\MultimediaStatusChangeEvent;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class StatusChangeHandlerListener.
 *
 * @package App\EventListener\MultimediaStatusChange
 *
 * @author  Codememory
 */
class StatusChangeHandlerListener
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function onMultimediaStatusChange(MultimediaStatusChangeEvent $event): void
    {
        switch ($event->onStatus) {
            case MultimediaStatusEnum::PUBLISHED:
                $this->publishStatusHandler($event);
                break;
            case MultimediaStatusEnum::UNPUBLISHED:
                $this->unpublishStatusHandler($event);
                break;
            case MultimediaStatusEnum::MODERATION:
                $this->moderationStatusHandler($event);
                break;
            case MultimediaStatusEnum::APPEAL:
            case MultimediaStatusEnum::APPEAL_CANCELED:
                $this->changeStatus($event);
                break;
            default:
                break;
        }

        $this->em->flush();
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
            $this->em->remove($event->multimedia->getQueue());
        }
    }

    private function unpublishStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);

        if (null !== $event->multimedia->getQueue()) {
            $this->em->remove($event->multimedia->getQueue());
        }
    }

    private function changeStatus(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);
    }
}