<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case PAID = 'status.paid';
    case NOT_PAID = 'status.not_paid';
    case PENDING = 'status.pending';
}