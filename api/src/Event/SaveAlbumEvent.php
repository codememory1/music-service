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
    /**
     * @var AlbumDTO
     */
    public readonly AlbumDTO $albumDTO;

    /**
     * @var Album
     */
    public readonly Album $album;

    /**
     * @param AlbumDTO $albumDTO
     * @param Album    $album
     */
    public function __construct(AlbumDTO $albumDTO, Album $album)
    {
        $this->albumDTO = $albumDTO;
        $this->album = $album;
    }
}