<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Event\UserRegistrationEvent;
use App\Service\FlusherService;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(UserRegistrationEvent::class, 'onUserRegistration', 1)]
final class CreateAccountActivationCodeListener
{
    public function __construct(
        private readonly FlusherService $flusherService
    ) {
    }

    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $accountActivationCodeEntity = new AccountActivationCode();

        $accountActivationCodeEntity->setUser($event->user);
        $accountActivationCodeEntity->setTtl('1h');

        $this->flusherService->save($accountActivationCodeEntity);
    }
}