<?php

namespace App\Enum;

enum AlbumStatusEnum: string
{
    case PUBLISHED = 'status.published';
    case UNPUBLISHED = 'status.unpublished';
}