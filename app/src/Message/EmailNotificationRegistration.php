<?php

namespace App\Message;

/**
 * Class EmailNotificationRegistration
 *
 * @package App\Message
 *
 * @author  Codememory
 */
class EmailNotificationRegistration
{

    /**
     * @var int
     */
    private int $userId;

    /**
     * @param int $userId
     */
    public function __construct(int $userId)
    {

        $this->userId = $userId;

    }

    /**
     * @return int
     */
    public function getUser(): int
    {

        return $this->userId;

    }

}