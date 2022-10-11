<?php

namespace App\Enum;

enum PaymentStatusEnum
{
    case PAID;
    case NOT_PAID;
    case PENDING;
}