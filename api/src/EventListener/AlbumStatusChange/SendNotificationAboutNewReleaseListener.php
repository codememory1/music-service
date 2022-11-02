<?php

namespace App\EventListener\AlbumStatusChange;

use App\Enum\AlbumStatusEnum;
use App\Event\AlbumStatusChangeEvent;
use App\Service\Notification\NotificationCollection;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(AlbumStatusChangeEvent::class, 'onAlbumStatusChange', 1)]
final class SendNotificationAboutNewReleaseListener
{
    public function __construct(
        private readonly NotificationCollection $notificationCollection
    ) {}

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