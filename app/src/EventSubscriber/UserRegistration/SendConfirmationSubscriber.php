<?php

namespace App\EventSubscriber\UserRegistration;

use App\Entity\UserActivationToken;
use App\Enums\EventsEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\UserActivationTokenRepository;
use Doctrine\Persistence\ManagerRegistry;
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
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param MailerInterface $mailer
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(MailerInterface $mailer, ManagerRegistry $managerRegistry)
    {

        $this->mailer = $mailer;
        $this->managerRegistry = $managerRegistry;

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

        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->managerRegistry->getRepository(UserActivationToken::class);

        $userActivationToken = $userActivationTokenRepository->findOneBy([
            'user' => $event->getUser()
        ]);

        $email = new Email();
        $email
            ->from('kostynd1@gmail.com')
            ->to($event->getUser()->getEmail())
            ->subject('Регистрация')
            ->html($userActivationToken->getToken());

        $this->mailer->send($email);

    }

}