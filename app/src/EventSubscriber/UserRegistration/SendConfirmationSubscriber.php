<?php

namespace App\EventSubscriber\UserRegistration;

use App\Enums\EventsEnum;
use App\Event\UserRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Class SendConfirmationSubscriber
 *
 * @package App\EventSubscriber\UserRegistration
 *
 * @author  Codememory
 */
class SendConfirmationSubscriber implements EventSubscriberInterface
{

    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;

    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {

        return [
            EventsEnum::USER_REGISTRATION->value => 'onUserRegistration'
        ];

    }

    /**
     * @param UserRegistrationEvent $event
     *
     * @return void
     * @throws TransportExceptionInterface
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {

        $email = new Email();

        $email
            ->from('kostynd1@gmail.com')
            ->to($event->getUser()->getEmail())
            ->subject('Регистрация')
            ->html('Html');

        $this->mailer->send($email);

    }

}