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
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @param MultimediaStatusChangeEvent $event
     *
     * @return void
     */
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

    /**
     * @param MultimediaStatusChangeEvent $event
     *
     * @return void
     */
    public function moderationStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);
        $event->multimedia->setQueue(new MultimediaQueue());
    }

    /**
     * @param MultimediaStatusChangeEvent $event
     *
     * @return void
     */
    private function publishStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);

        if (null !== $event->multimedia->getQueue()) {
            $this->em->remove($event->multimedia->getQueue());
        }
    }

    /**
     * @param MultimediaStatusChangeEvent $event
     *
     * @return void
     */
    private function unpublishStatusHandler(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);

        if (null !== $event->multimedia->getQueue()) {
            $this->em->remove($event->multimedia->getQueue());
        }
    }

    /**
     * @param MultimediaStatusChangeEvent $event
     *
     * @return void
     */
    private function changeStatus(MultimediaStatusChangeEvent $event): void
    {
        $event->multimedia->setStatus($event->onStatus);
    }
}