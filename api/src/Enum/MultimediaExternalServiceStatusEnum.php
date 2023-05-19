<?php

namespace App\Enum;

enum MultimediaExternalServiceStatusEnum: string
{
    case PUBLISHED = 'status.published';
    case UNPUBLISHED = 'status.unpublished';
    case BLOCKED = 'status.blocked';
}
