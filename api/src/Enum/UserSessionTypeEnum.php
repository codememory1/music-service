<?php

namespace App\Enum;

enum UserSessionTypeEnum: string
{
    case TEMP = 'type.temp';
    case REGISTRATION = 'type.registration';
}