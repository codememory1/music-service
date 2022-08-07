<?php

namespace App\Enum;

/**
 * Enum WebSocketClientMessageTypeEnum.
 *
 * @package App\Enum
 *
 * @author  Codememory
 */
enum WebSocketClientMessageTypeEnum
{
    case STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT;
    case MULTIMEDIA_BROADCAST_REQUEST;
}