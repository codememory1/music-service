<?php

namespace App\Enums;

/**
 * Enum ApiResponseTypeEnum
 *
 * @package App\Enums
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

}