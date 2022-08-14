<?php

namespace App\Event;

use App\Entity\Multimedia;

final class SaveMultimediaEvent
{
    public readonly Multimedia $multimedia;

    public function __construct(Multimedia $multimedia)
    {
        $this->multimedia = $multimedia;
    }
}