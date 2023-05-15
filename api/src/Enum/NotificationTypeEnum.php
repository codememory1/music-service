<?php

namespace App\Enum;

enum NotificationTypeEnum: string
{
    case INFORMATIONAL = 'type.informational';
    case REFERENTIAL = 'type.referential';
}