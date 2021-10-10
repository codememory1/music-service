<?php

namespace App\Listeners;

use App\Events\UserRegisterEvent;
use Codememory\Components\Event\Interfaces\ListenerInterface;
use Codememory\Components\Mail\Interfaces\MessageInterface;

/**
 * Class RegistrationMailSenderListener
 *
 * @package App\Listeners
 *
 * @author  Danil
 */
class RegistrationMailSenderListener implements ListenerInterface
{

    /**
     * @param UserRegisterEvent $event
     *
     * @return void
     */
    public function handle(UserRegisterEvent $event): void
    {

        $event->mailer->createMessage(function (MessageInterface $message) use ($event) {
            $message
                ->setSubject('Подтверждение регистрации')
                ->addRecipientAddress($event->userEntity->getEmail())
                ->setBody($event->activationTokenEntity->getToken());
        })->send();

    }

}