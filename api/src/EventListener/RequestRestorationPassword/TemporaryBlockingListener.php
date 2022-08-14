<?php

namespace App\EventListener\RequestRestorationPassword;

use App\Event\RequestRestorationPasswordEvent;
use App\Rest\Http\Exceptions\FailedException;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;

#[AsEntityListener('app.after-password-reset.request', 'onAfterRequestRestorationPassword', 1)]
final class TemporaryBlockingListener
{
    public function onAfterRequestRestorationPassword(RequestRestorationPasswordEvent $event): void
    {
        if ($event->passwordReset->getUser()->getPasswordResets()->count() >= 10) {
            throw FailedException::failedSendOnRequestRestorationPassword();
        }
    }
}