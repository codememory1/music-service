<?php

namespace App\Event;

use App\Entity\MultimediaRating;

final class SetRatingMultimediaEvent
{
    public function __construct(
        public readonly MultimediaRating $multimediaRating
    ) {
    }
}