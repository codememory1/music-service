<?php

namespace App\Listeners;

use App\Events\UserRegisterEventEvent;
use Codememory\Components\Event\Interfaces\ListenerInterface;
use Codememory\Components\Mail\Interfaces\MessageInterface;

/**
 * Class RegistrationMailSenderListener
 *
 * @package App\Listeners
 */
class RegistrationMailSenderListener implements ListenerInterface
{

    /**
     * @param UserRegisterEventEvent $event
     *
     * @return void
     */
    public function handle(UserRegisterEventEvent $event): void
    {

        $event->mailer->createMessage(function (MessageInterface $message) use ($event) {
            $message
                ->setSubject('Подтверждение регистрации')
                ->addRecipientAddress($event->userEntity->getEmail())
                ->setBody($event->userEntity->getActivationToken());
        })->send();

    }

}