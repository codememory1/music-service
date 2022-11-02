<?php

namespace App\Dto\Transfer\WebSocket;

use App\Dto\Constraints as DtoConstraints;
use App\Infrastucture\Dto\AbstractDataTransfer;
use App\Entity\StreamRunningMultimedia;
use Symfony\Component\Validator\Constraints as Assert;

final class AcceptOfferedStreamingDto extends AbstractDataTransfer
{
    #[Assert\NotBlank(message: 'entityNotFound@streamRunningMultimedia')]
    #[DtoConstraints\ToEntityConstraint('id')]
    public ?StreamRunningMultimedia $streamRunningMultimedia = null;
}