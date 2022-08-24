<?php

namespace App\Enum;

enum WebSocketUserMessageTypeHandlerEnum: string
{
    case CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_CURRENT_ACCOUNT = 'App\Service\WebSocket\Handle\CreateStreamMultimediaOfferBetweenCurrentAccountHandler';
    case ACCEPT_OFFERED_STREAMING = 'App\Service\WebSocket\Handle\AcceptOfferedStreamingHandler';
    case REJECT_OFFERED_STREAMING = 'App\Service\WebSocket\Handle\RejectOfferedStreamingHandler';

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