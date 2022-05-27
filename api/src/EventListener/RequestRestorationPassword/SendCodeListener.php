<?php

namespace App\EventListener\RequestRestorationPassword;

use App\Event\RequestRestorationPasswordEvent;
use App\Service\MailMessagingService;

/**
 * Class SendCodeListener.
 *
 * @package App\EventListener\RequestRestorationPassword
 *
 * @author  Codememory
 */
class SendCodeListener
{
    /**
     * @var MailMessagingService
     */
    private MailMessagingService $mailMessagingService;

    /**
     * @param MailMessagingService $mailMessagingService
     */
    public function __construct(MailMessagingService $mailMessagingService)
    {
        $this->mailMessagingService = $mailMessagingService;
    }

    public function onRequestRestorationPassword(RequestRestorationPasswordEvent $event): void
    {
        $this->mailMessagingService->sendRequestRestorationPassword($event->passwordReset);
    }
}