<?php

namespace App\Event;

use App\Entity\Multimedia;

/**
 * Class SaveMultimediaEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class SaveMultimediaEvent
{
    public readonly Multimedia $multimedia;

    public function __construct(Multimedia $multimedia)
    {
        $this->multimedia = $multimedia;
    }
}