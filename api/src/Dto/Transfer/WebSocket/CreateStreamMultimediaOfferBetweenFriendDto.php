<?php

namespace App\Dto\Transfer\WebSocket;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateStreamMultimediaOfferBetweenFriendDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'streamMultimedia@multimediaIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $runningMultimedia = null;

    #[Assert\NotBlank(message: 'streamMultimedia@toFriendIsRequired')]
    #[DtoConstraints\ToTypeConstraint]
    public ?int $toFriend = null;
}