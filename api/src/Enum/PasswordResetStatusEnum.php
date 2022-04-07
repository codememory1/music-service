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
    case WAITING_RESET = 0;
    case RESET = 1;
}