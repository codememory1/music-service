<?php

namespace App\EventSubscriber\UserPasswordChange;

use App\Enum\EventEnum;
use App\Event\UserPasswordChangeEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class SendMailNotificationSubscriber.
 *
 * @package App\UserPasswordChange\EventSubscriber
 *
 * @author  Codememory
 */
class SendMailNotificationSubscriber implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventEnum::USER_PASSWORD_CHANGE->value => 'onChangePassword'
        ];
    }

    /**
     * @param UserPasswordChangeEvent $event
     *
     * @return void
     */
    public function onChangePassword(UserPasswordChangeEvent $event): void
    {
    }
}