<?php

namespace App\Enum;

enum MultimediaDeleteTypeEnum: string
{
    case COMPLETE = 'type.complete';
    case NOT_COMPLETE = 'type.not_complete';
}