<?php

namespace App\Enum;

enum PasswordResetStatusEnum
{
    case IN_PROCESS;
    case COMPLETED;
}