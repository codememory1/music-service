<?php

namespace App\Enum;

enum PaymentTypeEnum: string
{
    case MANUAL = 'type.manual';
    case AUTO = 'type.auto';
}