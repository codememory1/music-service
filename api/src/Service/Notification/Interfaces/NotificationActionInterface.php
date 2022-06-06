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
    /**
     * @return array
     */
    public function getAction(): array;
}