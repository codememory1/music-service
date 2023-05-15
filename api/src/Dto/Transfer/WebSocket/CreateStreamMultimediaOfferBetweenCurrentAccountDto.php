<?php

namespace App\Dto\Transfer\WebSocket;

use Codememory\Dto\Constraints as DC;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class CreateStreamMultimediaOfferBetweenCurrentAccountDto extends DataTransfer
{
    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'streamMultimedia@multimediaIsRequired')
    ])]
    public ?int $runningMultimedia = null;

    #[DC\ToType]
    #[DC\Validation([
        new Assert\NotBlank(message: 'streamMultimedia@toUserSessionIsRequired')
    ])]
    public ?int $toUserSession = null;
}