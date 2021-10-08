<?php

namespace App\Events;

use App\Listeners\RegistrationMailSenderListener;
use App\Orm\Entities\ActivationTokenEntity;
use App\Orm\Entities\UserEntity;
use Codememory\Components\Event\Interfaces\EventInterface;
use Codememory\Components\Mail\Interfaces\MailerInterface;
use Codememory\Components\Mail\Interfaces\MailerPackInterface;

/**
 * Class UserRegisterEvent
 *
 * @package App\Events
 *
 * @after   Danil
 */
class UserRegisterEvent implements EventInterface
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
     * @var ActivationTokenEntity
     */
    public ActivationTokenEntity $activationTokenEntity;

    /**
     * UserRegisterEvent Construct
     */
    public function __construct(MailerPackInterface $mailerPack, UserEntity $userEntity, ActivationTokenEntity $activationTokenEntity)
    {

        $this->mailer = $mailerPack->getMailer();
        $this->userEntity = $userEntity;
        $this->activationTokenEntity = $activationTokenEntity;

    }

    /**
     * @inheritDoc
     */
    public function getListeners(): array
    {

        return [
            RegistrationMailSenderListener::class
        ];

    }

}