<?php

namespace App\EventSubscriber\UserRegistration;

use App\Entity\UserActivationToken;
use App\Enum\EventsEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\UserActivationTokenRepository;
use App\Service\MailNotificationService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @var MailNotificationService
     */
    private MailNotificationService $mailerNotificationService;

    /**
     * @param ManagerRegistry         $managerRegistry
     * @param MailNotificationService $mailNotificationService
     */
    public function __construct(ManagerRegistry $managerRegistry, MailNotificationService $mailNotificationService)
    {

        $this->managerRegistry = $managerRegistry;
        $this->mailerNotificationService = $mailNotificationService;

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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {

        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->managerRegistry->getRepository(UserActivationToken::class);

        $userActivationToken = $userActivationTokenRepository->findOneBy([
            'user' => $event->getUser()
        ]);

        $this->mailerNotificationService->registerNotification($event->getUser(), $userActivationToken);

    }

}