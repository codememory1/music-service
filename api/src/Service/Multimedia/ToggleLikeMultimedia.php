<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;

final class ToggleLikeMultimedia
{
    public function __construct(
        private readonly ToggleRatingMultimedia $toggleRatingMultimedia
    ) {
    }

    public function toggle(Multimedia $multimedia, User $from, ?callable $callbackRemove = null): Multimedia
    {
        $this->toggleRatingMultimedia->toggle(
            $multimedia,
            $from,
            MultimediaRatingTypeEnum::LIKE,
            MultimediaRatingTypeEnum::DISLIKE,
            $callbackRemove
        );

        return $multimedia;
    }
}