<?php

namespace App\Enum;

/**
 * Enum ResponseTypeEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum ResponseTypeEnum
{
    case CREATE;
    case UPDATE;
    case DELETE;
    case CHECK_CORRECTNESS;
    case CHECK_VALID;
    case SUCCESS_AUTHORIZATION;
    case SUCCESS_REGISTRATION;
}