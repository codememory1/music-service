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
    case CHECK_EXIST = 'CHECK_EXIST';
    case CREATE = 'CREATE';
    case UPDATE = 'UPDATE';
    case DELETE = 'DELETE';
    case CHECK_VALID = 'CHECK_VALID';
    case CHECK_INCORRECT = 'CHECK_INCORRECT';
    case CHECK_ACTIVE = 'CHECK_ACTIVE';
    case CHECK_ROLE_PERMISSION = 'CHECK_PERMISSION';
    case CHECK_AUTH = 'CHECK_AUTH';
    case CHECK_ROLE = 'CHECK_ROLE';
    case CHECK_SUBSCRIPTION = 'CHECK_SUBSCRIPTION';
    case CHECK_SUBSCRIPTION_PERMISSION = 'CHECK_SUBSCRIPTION_PERMISSION';
    case SHOW = 'SHOW';
    case AUTH = 'AUTH';
    case REGISTRATION = 'REGISTRATION';
    case ACTIVATION_ACCOUNT = 'ACTIVATION_ACCOUNT';
    case ACCESS_IS_DENIED = 'ACCESS_IS_DENIED';
}