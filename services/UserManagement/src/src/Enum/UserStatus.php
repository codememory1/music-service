<?php

namespace App\Enum;

enum UserStatus: string
{
    case ACTIVATED = 'status.activated';
    case NOT_ACTIVATED = 'status.not_activated';
    case LOCKED = 'status.locked';
}