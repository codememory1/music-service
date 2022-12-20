<?php

namespace App\Enum;

enum RequestTypeEnum: string
{
    case ADMIN = 'admin';
    case PUBLIC = 'public';
}