<?php

namespace App\Events;

use App\Listeners\RegistrationMailSenderListener;
use App\Orm\Entities\UserEntity;
use Codememory\Components\Event\Interfaces\EventInterface;
use Codememory\Components\Mail\Interfaces\MailerInterface;
use Codememory\Components\Mail\Interfaces\MailerPackInterface;

/**
 * Class UserRegisterEventEvent
 *
 * @package App\Events
 *
 * @after   Danil
 */
class UserRegisterEventEvent implements EventInterface
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
     * UserRegisterEvent Construct
     */
    public function __construct(MailerPackInterface $mailerPack, UserEntity $userEntity)
    {

        $this->mailer = $mailerPack->getMailer();
        $this->userEntity = $userEntity;

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