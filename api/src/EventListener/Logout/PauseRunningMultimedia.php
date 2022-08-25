<?php

namespace App\EventListener\Logout;

use App\Event\LogoutEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(method: 'onLogout')]
final class PauseRunningMultimedia
{
    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    public function onLogout(LogoutEvent $event): void
    {
        if (null !== $event->userSession->getRunningMultimedia()) {
            $event->userSession->getRunningMultimedia()->pause();

            $this->em->flush();
        }
    }
}