<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Event\UserRegistrationEvent;
use App\Service\FlusherService;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener('app.registration', 'onUserRegistration', 1)]
final class CreateAccountActivationCodeListener
{
    private FlusherService $flusherService;

    public function __construct(FlusherService $flusherService)
    {
        $this->flusherService = $flusherService;
    }

    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $accountActivationCodeEntity = new AccountActivationCode();

        $accountActivationCodeEntity->setUser($event->user);
        $accountActivationCodeEntity->setTtl('1h');

        $this->flusherService->save($accountActivationCodeEntity);
    }
}