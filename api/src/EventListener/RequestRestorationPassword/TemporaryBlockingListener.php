<?php

namespace App\EventListener\RequestRestorationPassword;

use App\Event\RequestRestorationPasswordEvent;
use App\Rest\Http\Exceptions\FailedException;

/**
 * Class TemporaryBlockingListener.
 *
 * @package App\EventListener\RequestRestorationPassword
 *
 * @author  Codememory
 */
class TemporaryBlockingListener
{
    public function onAfterRequestRestorationPassword(RequestRestorationPasswordEvent $event): void
    {
        if ($event->passwordReset->getUser()->getPasswordResets()->count() >= 10) {
            throw FailedException::failedSendOnRequestRestorationPassword();
        }
    }
}