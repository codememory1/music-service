<?php

namespace App\Service\Notification\Interfaces;

/**
 * Interface NotificationTypeInterface.
 *
 * @package  App\Service\Notification\Interfaces
 *
 * @author   Codememory
 */
interface NotificationActionInterface
{
    public function getAction(): array;
}