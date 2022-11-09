<?php

namespace App\EventListener\RequestRestorationPassword;

use App\Event\RequestRestorationPasswordEvent;
use App\Service\MailMessaging;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsEventListener(RequestRestorationPasswordEvent::class, 'onRequestRestorationPassword')]
final class SendCodeListener
{
    public function __construct(
        private readonly MailMessaging $mailMessagingService
    ) {
    }

    /**
     * @throws SyntaxError
     * @throws TransportExceptionInterface
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function onRequestRestorationPassword(RequestRestorationPasswordEvent $event): void
    {
        $this->mailMessagingService->sendRequestRestorationPassword($event->passwordReset);
    }
}