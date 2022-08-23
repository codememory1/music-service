<?php

namespace App\Enum;

enum WebSocketClientMessageTypeEnum
{
    case CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_CURRENT_ACCOUNT;
    case MULTIMEDIA_STREAM_OFFER;
}