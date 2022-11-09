<?php

namespace App\EventListener\Registration;

use App\Entity\AccountActivationCode;
use App\Event\UserRegistrationEvent;
use App\Infrastructure\Doctrine\Flusher;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(UserRegistrationEvent::class, 'onUserRegistration', 1)]
final class CreateAccountActivationCodeListener
{
    public function __construct(
        private readonly Flusher $flusher
    ) {
    }

    public function onUserRegistration(UserRegistrationEvent $event): void
    {
        $accountActivationCodeEntity = new AccountActivationCode();

        $accountActivationCodeEntity->setUser($event->user);
        $accountActivationCodeEntity->setTtl('1h');

        $this->flusher->save($accountActivationCodeEntity);
    }
}