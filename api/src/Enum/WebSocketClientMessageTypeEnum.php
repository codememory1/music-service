<?php

namespace App\Enum;

enum WebSocketClientMessageTypeEnum
{
    case STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT;
    case MULTIMEDIA_BROADCAST_REQUEST;
}