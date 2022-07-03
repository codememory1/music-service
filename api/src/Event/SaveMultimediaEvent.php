<?php

namespace App\Event;

use App\DTO\MultimediaDTO;
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
    public readonly MultimediaDTO $multimediaDTO;
    public readonly Multimedia $multimedia;

    public function __construct(MultimediaDTO $multimediaDTO, Multimedia $multimedia)
    {
        $this->multimediaDTO = $multimediaDTO;
        $this->multimedia = $multimedia;
    }
}