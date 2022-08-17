<?php

namespace App\Enum;

enum WebSocketUserMessageTypeHandlerEnum: string
{
    case STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT = 'App\Service\WebSocket\StreamMultimediaBetweenCurrentAccountHandlerService';

    public static function get(string $name): ?string
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case->value;
            }
        }

        return null;
    }
}