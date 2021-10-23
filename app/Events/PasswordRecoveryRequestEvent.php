<?php

namespace App\Events;

use App\Listeners\SendPasswordRecoverCodeListener;
use App\Orm\Entities\PasswordResetEntity;
use App\Orm\Entities\UserEntity;
use Codememory\Components\Event\Interfaces\EventInterface;
use Codememory\Components\Mail\Interfaces\MailerInterface;
use Codememory\Components\Mail\Interfaces\MailerPackInterface;

/**
 * Class PasswordRecoveryRequestEvent
 *
 * @package App\Events
 *
 * @author  Danil
 */
class PasswordRecoveryRequestEvent implements EventInterface
{

    /**
     * @var MailerInterface
     */
    public MailerInterface $mailer;

    /**
     * @var UserEntity
     */
    public UserEntity $userEntity;

    /**
     * @var PasswordResetEntity
     */
    public PasswordResetEntity $passwordResetEntity;

    /**
     * @param MailerPackInterface $mailerPack
     * @param UserEntity          $userEntity
     * @param PasswordResetEntity $passwordResetEntity
     */
    public function __construct(MailerPackInterface $mailerPack, UserEntity $userEntity, PasswordResetEntity $passwordResetEntity)
    {

        $this->mailer = $mailerPack->getMailer();
        $this->userEntity = $userEntity;
        $this->passwordResetEntity = $passwordResetEntity;

    }

    /**
     * @inheritDoc
     */
    public function getListeners(): array
    {

        return [
            SendPasswordRecoverCodeListener::class
        ];

    }

}