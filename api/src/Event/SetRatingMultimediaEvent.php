<?php

namespace App\Event;

use App\Entity\MultimediaRating;

/**
 * Class SetRatingMultimediaEvent.
 *
 * @package App\Event
 *
 * @author  Codememory
 */
class SetRatingMultimediaEvent
{
    public readonly MultimediaRating $multimediaRating;

    public function __construct(MultimediaRating $multimediaRating)
    {
        $this->multimediaRating = $multimediaRating;
    }
}