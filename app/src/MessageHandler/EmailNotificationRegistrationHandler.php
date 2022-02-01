<?php

namespace App\MessageHandler;

use App\Message\EmailNotificationRegistration;
use App\Repository\UserRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/**
 * Class EmailNotificationRegistrationHandler
 *
 * @package App\MessageHandler
 *
 * @author  Codememory
 */
#[AsMessageHandler]
class EmailNotificationRegistrationHandler
{

    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {

        $this->userRepository = $userRepository;

    }

    /**
     * @param EmailNotificationRegistration $message
     *
     * @return void
     */
    public function __invoke(EmailNotificationRegistration $message)
    {



    }

}