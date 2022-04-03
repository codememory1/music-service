<?php

namespace App\Enum;

/**
 * Enum PasswordResetStatusEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum PasswordResetStatusEnum: int
{
    case WAITING_RESET = 1;
    case RESET = 2;
}