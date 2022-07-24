<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Event\UserRegistrationEvent;
use App\Service\MailMessagingService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class SendAccountActivationCodeListener.
 *
 * @package App\EventListener\Registration
 *
 * @author  Codememory
 */
class SendAccountActivationCodeListener
{
    private EntityManagerInterface $em;
    private MailMessagingService $mailMessagingService;

    public function __construct(EntityManagerInterface $manager, MailMessagingService $mailMessagingService)
    {
        $this->em = $manager;
        $this->mailMessagingService = $mailMessagingService;
    }

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