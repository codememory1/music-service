<?php

namespace App\EventListener\RequestRestorationPassword;

use App\Event\RequestRestorationPasswordEvent;
use App\Service\MailMessagingService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SendCodeListener.
 *
 * @package App\EventListener\RequestRestorationPassword
 *
 * @author  Codememory
 */
class SendCodeListener
{
    private MailMessagingService $mailMessagingService;

    public function __construct(MailMessagingService $mailMessagingService)
    {
        $this->mailMessagingService = $mailMessagingService;
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