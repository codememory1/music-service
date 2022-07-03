<?php

namespace App\Enum;

/**
 * Enum WebSocketUserMessageTypeHandlerEnum.
 *
 * @package App\Enum
 *
 * @author  Сodememory
 */
enum WebSocketUserMessageTypeHandlerEnum: string
{
    // example -> case TEST_HANDLER = 'App\Service\WebSocket\TestUserMessageHandlerService';

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