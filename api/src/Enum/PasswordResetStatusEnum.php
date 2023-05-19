<?php

namespace App\Enum;

enum PasswordResetStatusEnum: string
{
    case IN_PROCESS = 'status.in_process';
    case COMPLETED = 'status.completed';
}