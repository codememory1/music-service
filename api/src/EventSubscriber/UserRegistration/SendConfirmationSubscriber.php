<?php

namespace App\EventSubscriber\UserRegistration;

use App\Entity\UserActivationToken;
use App\Enum\EventEnum;
use App\Event\UserRegistrationEvent;
use App\Repository\UserActivationTokenRepository;
use App\Service\MailNotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SendConfirmationSubscriber.
 *
 * @package App\EventSubscriber\UserRegistration
 *
 * @author  Codememory
 */
class SendConfirmationSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var MailNotificationService
     */
    private MailNotificationService $mailerNotificationService;

    /**
     * @param EntityManagerInterface  $em
     * @param MailNotificationService $mailNotificationService
     */
    public function __construct(EntityManagerInterface $em, MailNotificationService $mailNotificationService)
    {
        $this->em = $em;
        $this->mailerNotificationService = $mailNotificationService;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventEnum::USER_REGISTRATION->value => 'onUserRegistration'
        ];
    }

    /**
     * @param UserRegistrationEvent $event
     *
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     *
     * @return void
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        /** @var UserActivationTokenRepository $userActivationTokenRepository */
        $userActivationTokenRepository = $this->em->getRepository(UserActivationToken::class);

        $userActivationToken = $userActivationTokenRepository->findOneBy([
            'user' => $event->user
        ]);

        $this->mailerNotificationService->registerNotification($event->user, $userActivationToken);
    }
}