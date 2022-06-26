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
    /**
     * @var MultimediaRating
     */
    public readonly MultimediaRating $multimediaRating;

    /**
     * @param MultimediaRating $multimediaRating
     */
    public function __construct(MultimediaRating $multimediaRating)
    {
        $this->multimediaRating = $multimediaRating;
    }
}