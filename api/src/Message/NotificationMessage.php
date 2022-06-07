<?php

namespace App\Message;

/**
 * Class NotificationMessage.
 *
 * @package App\Message
 *
 * @author  Codememory
 */
class NotificationMessage
{
    /**
     * @var array
     */
    public readonly array $notification;

    /**
     * @var string
     */
    public readonly string $to;

    /**
     * @param array  $notification
     * @param string $to
     */
    public function __construct(array $notification, string $to)
    {
        $this->notification = $notification;
        $this->to = $to;
    }
}