<?php

namespace App\Event;

use App\DTO\PlaylistDTO;
use App\Entity\Playlist;

/**
 * Class SavePlaylistEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class SavePlaylistEvent
{
    public readonly Playlist $playlist;
    public readonly PlaylistDTO $playlistDTO;

    public function __construct(Playlist $playlist, PlaylistDTO $playlistDTO)
    {
        $this->playlist = $playlist;
        $this->playlistDTO = $playlistDTO;
    }
}