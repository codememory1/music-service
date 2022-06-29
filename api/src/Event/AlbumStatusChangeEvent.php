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
    /**
     * @var Album
     */
    public readonly Album $album;

    /**
     * @var AlbumStatusEnum
     */
    public readonly AlbumStatusEnum $onStatus;

    /**
     * @param Album           $album
     * @param AlbumStatusEnum $onStatus
     */
    public function __construct(Album $album, AlbumStatusEnum $onStatus)
    {
        $this->album = $album;
        $this->onStatus = $onStatus;
    }
}