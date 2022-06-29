<?php

namespace App\EventListener\AlbumStatusChange;

use App\Enum\AlbumStatusEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Service\Notification\NotificationCollection;

/**
 * Class SendNotificationAboutNewReleaseListener.
 *
 * @package App\EventListener\AlbumStatusChange
 *
 * @author  codememory
 */
class SendNotificationAboutNewReleaseListener
{
    /**
     * @var NotificationCollection
     */
    private NotificationCollection $notificationCollection;

    /**
     * @param NotificationCollection $notificationCollection
     */
    public function __construct(NotificationCollection $notificationCollection)
    {
        $this->notificationCollection = $notificationCollection;
    }

    /**
     * @param AlbumStatusChangeEvent $event
     *
     * @return void
     */
    public function onAlbumStatusChange(AlbumStatusChangeEvent $event): void
    {
        if (AlbumStatusEnum::PUBLISHED === $event->onStatus) {
            $subscribers = $event->album->getUser()->getSubscribers();

            foreach ($subscribers as $subscriber) {
                $this->notificationCollection->newRelease($event->album, $subscriber->getSubscriber());
            }
        }
    }
}