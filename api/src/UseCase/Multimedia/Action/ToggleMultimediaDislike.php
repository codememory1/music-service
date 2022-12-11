<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;

final class ToggleMultimediaDislike
{
    public function __construct(
        private readonly ToggleMultimediaRating $toggleMultimediaRating
    ) {
    }

    public function process(Multimedia $multimedia, User $owner): MultimediaRating
    {
        return $this->toggleMultimediaRating->process(
            $multimedia,
            MultimediaRatingTypeEnum::DISLIKE,
            MultimediaRatingTypeEnum::LIKE,
            $owner
        );
    }
}