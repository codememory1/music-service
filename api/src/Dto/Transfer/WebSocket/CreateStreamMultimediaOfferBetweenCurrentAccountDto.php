<?php

namespace App\Dto\Transfer\WebSocket;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastucture\Dto\AbstractDataTransfer;
use App\Enum\WebSocketClientMessageTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateStreamMultimediaOfferBetweenCurrentAccountDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'streamMultimedia@multimediaIsRequired', payload: [WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_CURRENT_ACCOUNT])]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $runningMultimedia = null;

    #[Assert\NotBlank(message: 'streamMultimedia@toUserSessionIsRequired', payload: [WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_CURRENT_ACCOUNT])]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $toUserSession = null;
}