<?php

namespace App\Event;

use App\Entity\Album;
use App\Enum\AlbumStatusEnum;

/**
 * Class AlbumStatusChangeEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class AlbumStatusChangeEvent
{
    public readonly Album $album;
    public readonly AlbumStatusEnum $onStatus;

    public function __construct(Album $album, AlbumStatusEnum $onStatus)
    {
        $this->album = $album;
        $this->onStatus = $onStatus;
    }
}