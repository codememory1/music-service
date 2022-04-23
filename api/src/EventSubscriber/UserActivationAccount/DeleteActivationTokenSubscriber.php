<?php

namespace App\EventSubscriber\UserActivationAccount;

use App\Enum\EventEnum;
use App\Event\UserActivationAccountEvent;
use App\Service\UserActivationToken\DeleterToken;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class DeleteActivationTokenSubscriber
 *
 * @package App\EventSubscriber\UserActivationAccount
 *
 * @author  Codememory
 */
class DeleteActivationTokenSubscriber implements EventSubscriberInterface
{
    /**
     * @var DeleterToken
     */
    private DeleterToken $deleterUserActivationToken;

    /**
     * @param DeleterToken $deleterToken
     */
    public function __construct(DeleterToken $deleterToken)
    {
        $this->deleterUserActivationToken = $deleterToken;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            EventEnum::USER_ACTIVATION_ACCOUNT->value => 'onUserActivationAccount'
        ];
    }

    /**
     * @param UserActivationAccountEvent $event
     *
     * @return void
     */
    public function onUserActivationAccount(UserActivationAccountEvent $event): void
    {
        $this->deleterUserActivationToken->delete($event->userActivationToken);
    }
}