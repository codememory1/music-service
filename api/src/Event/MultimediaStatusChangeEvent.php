<?php

namespace App\Event;

use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;

final class MultimediaStatusChangeEvent
{
    public function __construct(
        public readonly Multimedia $multimedia,
        public readonly MultimediaStatusEnum $onStatus
    ) {
    }
}