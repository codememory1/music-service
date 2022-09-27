<?php

namespace App\Dto\Transfer\WebSocket;

use App\Dto\Constraints as DtoConstraints;
use App\Dto\Transfer\AbstractDataTransfer;
use App\Enum\WebSocketClientMessageTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateStreamMultimediaOfferBetweenFriendDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'streamMultimedia@multimediaIsRequired', payload: [WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_FRIEND])]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $runningMultimedia = null;

    #[Assert\NotBlank(message: 'streamMultimedia@toFriendIsRequired', payload: [WebSocketClientMessageTypeEnum::CREATE_STREAM_MULTIMEDIA_OFFER_BETWEEN_FRIEND])]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $toFriend = null;
}