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
    private NotificationCollection $notificationCollection;

    public function __construct(NotificationCollection $notificationCollection)
    {
        $this->notificationCollection = $notificationCollection;
    }

    public function onAlbumStatusChange(AlbumStatusChangeEvent $event): void
    {
        match ($event->onStatus) {
            AlbumStatusEnum::PUBLISHED => $this->publish($event)
        };
    }

    private function publish(AlbumStatusChangeEvent $event): void
    {
        $subscribers = $event->album->getUser()->getSubscribers();

        foreach ($subscribers as $subscriber) {
            $this->notificationCollection->newRelease($event->album, $subscriber->getSubscriber());
        }
    }
}