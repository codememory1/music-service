<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;

final class ToggleDislikeMultimedia
{
    public function __construct(
        private readonly ToggleRatingMultimedia $upsertMultimediaRating
    ) {
    }

    public function toggle(Multimedia $multimedia, User $from, ?callable $callbackRemove = null): Multimedia
    {
        $this->upsertMultimediaRating->toggle(
            $multimedia,
            $from,
            MultimediaRatingTypeEnum::DISLIKE,
            MultimediaRatingTypeEnum::LIKE,
            $callbackRemove
        );

        return $multimedia;
    }
}