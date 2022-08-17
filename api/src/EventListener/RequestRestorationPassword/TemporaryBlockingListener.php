<?php

namespace App\EventListener\RequestRestorationPassword;

use App\Event\RequestRestorationPasswordEvent;
use App\Exception\Http\FailedException;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener('app.after-password-reset.request', 'onAfterRequestRestorationPassword', 1)]
final class TemporaryBlockingListener
{
    public function onAfterRequestRestorationPassword(RequestRestorationPasswordEvent $event): void
    {
        if ($event->passwordReset->getUser()->getPasswordResets()->count() >= 10) {
            throw FailedException::failedSendOnRequestRestorationPassword();
        }
    }
}