<?php

namespace App\Dto\Transfer\WebSocket;

use Codememory\Dto\Constraints as DC;
use App\Entity\StreamRunningMultimedia;
use Codememory\Dto\DataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class RejectOfferedStreamingDto extends DataTransfer
{
    #[DC\ToEntity(byKey: 'id')]
    #[DC\Validation([
        new Assert\NotBlank(message: 'entityNotFound@streamRunningMultimedia')
    ])]
    public ?StreamRunningMultimedia $streamRunningMultimedia = null;
}