<?php

namespace App\Event;

use App\DTO\AlbumDTO;
use App\Entity\Album;

/**
 * Class SaveAlbumEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class SaveAlbumEvent
{
    public readonly AlbumDTO $albumDTO;
    public readonly Album $album;

    public function __construct(AlbumDTO $albumDTO, Album $album)
    {
        $this->albumDTO = $albumDTO;
        $this->album = $album;
    }
}