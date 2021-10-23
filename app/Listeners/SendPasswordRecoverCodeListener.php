<?php

namespace App\Listeners;

use App\Events\PasswordRecoveryRequestEvent;
use Codememory\Components\Event\Interfaces\ListenerInterface;
use Codememory\Components\Mail\Interfaces\MessageInterface;

/**
 * Class SendPasswordRecoverCodeListener
 *
 * @package App\Listeners
 *
 * @author  Danil
 */
class SendPasswordRecoverCodeListener implements ListenerInterface
{

    /**
     * @param PasswordRecoveryRequestEvent $event
     */
    public function handle(PasswordRecoveryRequestEvent $event): void
    {

        $event->mailer->createMessage(function (MessageInterface $message) use ($event) {
            $message
                ->setSubject('Восстановление пароля')
                ->addRecipientAddress($event->userEntity->getEmail())
                ->setBody($event->passwordResetEntity->getCode());
        })->send();

    }

}