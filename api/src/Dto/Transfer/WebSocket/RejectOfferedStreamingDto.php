<?php

namespace App\Dto\Transfer\WebSocket;

use App\Dto\Constraints as DtoConstraints;
use App\Entity\StreamRunningMultimedia;
use App\Infrastructure\Dto\AbstractDataTransfer;
use Symfony\Component\Validator\Constraints as Assert;

final class RejectOfferedStreamingDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'entityNotFound@streamRunningMultimedia')]
    #[DtoConstraints\ToEntityConstraint('id')]
    public ?StreamRunningMultimedia $streamRunningMultimedia = null;
}