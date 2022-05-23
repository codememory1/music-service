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
    /**
     * @var MailMessagingService
     */
    private MailMessagingService $mailMessagingService;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param MailMessagingService   $mailMessagingService
     * @param EntityManagerInterface $manager
     */
    public function __construct(MailMessagingService $mailMessagingService, EntityManagerInterface $manager)
    {
        $this->mailMessagingService = $mailMessagingService;
        $this->em = $manager;
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
        $accountActivationCodeRepository = $this->em->getRepository(AccountActivationCode::class);

        $this->mailMessagingService->sendAccountActivationCode($accountActivationCodeRepository->findOneBy([
            'user' => $event->user
        ]));
    }
}