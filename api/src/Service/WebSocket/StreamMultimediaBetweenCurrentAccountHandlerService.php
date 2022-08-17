<?php

namespace App\Service\WebSocket;

use App\Entity\RunningMultimedia;
use App\Entity\StreamRunningMultimedia;
use App\Entity\UserSession;
use App\Enum\StreamMultimediaStatusEnum;
use App\Enum\WebSocketClientMessageTypeEnum;
use App\Exception\WebSocket\EntityNotFoundException;

final class StreamMultimediaBetweenCurrentAccountHandlerService extends AbstractUserMessageHandlerService
{
    protected ?WebSocketClientMessageTypeEnum $clientMessageType = WebSocketClientMessageTypeEnum::STREAM_MULTIMEDIA_BETWEEN_CURRENT_ACCOUNT;

    public function handler(): void
    {
        throw EntityNotFoundException::userSession(WebSocketClientMessageTypeEnum::MULTIMEDIA_BROADCAST_REQUEST);
    }
}