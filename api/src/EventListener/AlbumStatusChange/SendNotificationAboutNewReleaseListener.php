<?php

namespace App\EventListener\AlbumStatusChange;

use App\Enum\AlbumStatusEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Service\Notification\NotificationCollection;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('app.album.status-change', 'onAlbumStatusChange', 1)]
final class SendNotificationAboutNewReleaseListener
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