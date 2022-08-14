<?php

namespace App\Enum;

enum NotificationStatusEnum
{
    case PENDING;
    case IN_PROCESS_SENDING;
    case SENT_OUT;
}