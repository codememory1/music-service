<?php

namespace App\EventListener\Logout;

use App\Event\LogoutEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(LogoutEvent::class, method: 'onLogout')]
final class PauseRunningMultimedia
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {}

    public function onLogout(LogoutEvent $event): void
    {
        if (null !== $event->userSession->getRunningMultimedia()) {
            $event->userSession->getRunningMultimedia()->pause();

            $this->em->flush();
        }
    }
}