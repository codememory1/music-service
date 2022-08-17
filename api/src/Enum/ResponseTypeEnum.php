<?php

namespace App\Enum;

enum ResponseTypeEnum
{
    case CREATE;
    case UPDATE;
    case DELETE;
    case CHECK_CORRECTNESS;
    case CHECK_VALID;
    case SUCCESS_AUTHORIZATION;
    case SUCCESS_REGISTRATION;
    case EXIST;
    case NOT_EXIST;
    case INPUT_VALIDATION;
    case DATA_OUTPUT;
    case FAILED;
    case CHECK_AUTH;
    case CHECK_ACCESS;
    case SUCCESS_SEND;
    case UNAVAILABLE;
}