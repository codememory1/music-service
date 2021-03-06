<?php

namespace App\Enum;

/**
 * Enum WebSocketUserMessageTypeHandlerEnum.
 *
 * @package App\Enum
 *
 * @author  –°odememory
 */
enum WebSocketUserMessageTypeHandlerEnum: string
{
    // example -> case TEST_HANDLER = 'App\Service\WebSocket\TestUserMessageHandlerService';

    /**
     * @param string $name
     *
     * @return null|string
     */
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