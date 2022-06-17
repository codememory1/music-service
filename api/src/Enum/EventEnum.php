<?php

namespace App\Enum;

/**
 * Enum EventEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum EventEnum: string
{
    case REGISTER = 'app.registration';
    case IDENTIFICATION_IN_AUTH = 'app.auth.identification';
    case AUTHENTICATION_IN_AUTH = 'app.auth.authentication';
    case AUTHORIZATION = 'app.auth';
    case REQUEST_RESTORATION_PASSWORD = 'app.password-reset.request';
    case ACCOUNT_ACTIVATION = 'app.account-activation';
    case BEFORE_ADD_MULTIMEDIA = 'app.multimedia.before-add';
    case AFTER_ADD_MULTIMEDIA = 'app.multimedia.after-add';
}