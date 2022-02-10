<?php

namespace App\Enum;

/**
 * Enum ApiResponseTypeEnum
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum ApiResponseTypeEnum: string
{

    case INPUT_VALIDATION = 'input_validation';
    case CHECK_EXIST = 'check_exist';
    case CREATE = 'create';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case EXIST = 'exist';
    case IS_VALID = 'is_valid';
    case IS_INCORRECT = 'is_incorrect';
    case AUTH = 'auth';
    case CHECK_ACTIVE = 'check_active';

}