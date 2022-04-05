<?php

namespace App\EventSubscriber\PasswordRecoveryRequest;

use App\Enum\EventsEnum;
use App\Event\PasswordRecoveryRequestEvent;
use App\Service\MailNotificationService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SendToMailSubscriber.
 *
 * @package App\EventSubscriber\PasswordRecoveryRequest
 *
 * @author  Codememory
 */
class SendToMailSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailNotificationService
     */
    private MailNotificationService $mailNotificationService;

    /**
     * @param MailNotificationService $mailNotificationService
     */
    public function __construct(MailNotificationService $mailNotificationService)
    {
        $this->mailNotificationService = $mailNotificationService;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventsEnum::PASSWORD_RECOVERY_REQUEST->value => 'onRecoveryRequest'
        ];
    }

    /**
     * @param PasswordRecoveryRequestEvent $event
     *
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function onRecoveryRequest(PasswordRecoveryRequestEvent $event): void
    {
        $this->mailNotificationService->passwordRecoveryRequest(
            $event->getUser(),
            $event->getPasswordReset()
        );
    }
}