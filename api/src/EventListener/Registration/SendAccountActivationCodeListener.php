<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Event\UserRegistrationEvent;
use App\Service\MailMessagingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

#[AsEventListener(UserRegistrationEvent::class, 'onUserRegistration', 0)]
final class SendAccountActivationCodeListener
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MailMessagingService $mailMessagingService
    ) {}

    /**
     * @throws TransportExceptionInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $accountActivationCodeRepository = $this->em->getRepository(AccountActivationCode::class);

        $this->mailMessagingService->sendAccountActivationCode($accountActivationCodeRepository->findByUser($event->user));
    }
}