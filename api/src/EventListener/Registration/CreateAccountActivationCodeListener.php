<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Event\UserRegistrationEvent;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CreateAccountActivationCodeListener.
 *
 * @package App\EventListener\Registration
 *
 * @author  Codememory
 */
class CreateAccountActivationCodeListener
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->em = $manager;
    }

    /**
     * @param UserRegistrationEvent $event
     *
     * @return void
     */
    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $accountActivationCodeEntity = new AccountActivationCode();

        $accountActivationCodeEntity->setUser($event->user);
        $accountActivationCodeEntity->setTtl('1h');

        $this->em->persist($accountActivationCodeEntity);
        $this->em->flush();
    }
}