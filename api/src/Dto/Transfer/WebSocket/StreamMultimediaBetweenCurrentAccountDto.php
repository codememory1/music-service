<?php

namespace App\Dto\Transfer\WebSocket;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Transfer\AbstractDataTransfer;
use App\Enum\WebSocketClientMessageTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class StreamMultimediaBetweenCurrentAccountDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'multimedia@multimediaIsRequired', payload: [WebSocketClientMessageTypeEnum::MULTIMEDIA_BROADCAST_REQUEST])]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $runningMultimedia = null;

    #[Assert\NotBlank(message: 'streamMultimedia@toUserSessionIsRequired', payload: [WebSocketClientMessageTypeEnum::MULTIMEDIA_BROADCAST_REQUEST])]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $toUserSession = null;
}