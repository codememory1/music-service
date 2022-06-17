<?php

namespace App\Event;

use App\DTO\MultimediaDTO;
use App\Entity\Multimedia;

/**
 * Class AddMultimediaEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class AddMultimediaEvent
{
    /**
     * @var MultimediaDTO
     */
    public readonly MultimediaDTO $multimediaDTO;

    /**
     * @var Multimedia
     */
    public readonly Multimedia $multimedia;

    /**
     * @param MultimediaDTO $multimediaDTO
     * @param Multimedia    $multimedia
     */
    public function __construct(MultimediaDTO $multimediaDTO, Multimedia $multimedia)
    {
        $this->multimediaDTO = $multimediaDTO;
        $this->multimedia = $multimedia;
    }
}