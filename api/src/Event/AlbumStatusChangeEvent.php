<?php

namespace App\Event;

use App\Entity\Album;
use App\Enum\AlbumStatusEnum;

final class AlbumStatusChangeEvent
{
    public function __construct(
        public readonly Album $album,
        public readonly AlbumStatusEnum $onStatus
    ) {
    }
}