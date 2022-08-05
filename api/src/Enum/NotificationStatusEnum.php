<?php

namespace App\Enum;

/**
 * Enum NotificationStatusEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum NotificationStatusEnum
{
    case PENDING;
    case IN_PROCESS_SENDING;
    case SENT_OUT;
}