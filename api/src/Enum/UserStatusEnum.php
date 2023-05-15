<?php

namespace App\Enum;

enum UserStatusEnum: string
{
    case ACTIVE = 'status.active';
    case NOT_ACTIVE = 'status.not_active';
}