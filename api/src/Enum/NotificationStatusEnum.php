<?php

namespace App\Enum;

enum NotificationStatusEnum: string
{
    case PENDING = 'status.pending';
    case IN_PROCESS_SENDING = 'status.in_process_sending';
    case SENT_OUT = 'status.sent_out';
}