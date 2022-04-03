<?php

namespace App\Enum;

/**
 * Enum ApiResponseTypeEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum ApiResponseTypeEnum: string
{
    case ACTIVATION = 'ACTIVATION';
    case INPUT_VALIDATION = 'INPUT_VALIDATION';
    case CREATE = 'CREATE';
    case UPDATE = 'UPDATE';
    case DELETE = 'DELETE';
    case CHECK_VALID = 'CHECK_VALID';
	case CHECK_EXIST = 'CHECK_EXIST';
    case CHECK_ACTIVE = 'CHECK_ACTIVE';
    case CHECK_AUTH = 'CHECK_AUTH';
    case CHECK_ROLE = 'CHECK_ROLE';
    case INVALID = 'INVALID';
    case AUTH = 'AUTH';
    case REGISTRATION = 'REGISTRATION';
    case ACCESS_IS_DENIED = 'ACCESS_IS_DENIED';
    case DATA_OUTPUT = 'DATA_OUTPUT';
}