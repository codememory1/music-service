<?php

namespace App\Enum;

enum FriendStatusEnum: string
{
    case AWAITING_CONFIRMATION = 'status.awaiting_confirmation';
    case CONFIRMED = 'status.confirmed';
}