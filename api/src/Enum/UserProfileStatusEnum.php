<?php

namespace App\Enum;

enum UserProfileStatusEnum: string
{
    case HIDE = 'status.hide';
    case SHOW = 'status.show';
}