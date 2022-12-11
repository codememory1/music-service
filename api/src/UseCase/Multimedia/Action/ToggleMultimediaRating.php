<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Repository\MultimediaRatingRepository;

final class ToggleMultimediaRating
{
    public function __construct(
        private readonly AddMultimediaRating $addMultimediaRating,
        private readonly UpdateMultimediaRating $updateMultimediaRating,
        private readonly MultimediaRatingRepository $multimediaRatingRepository
    ) {
    }

    public function process(Multimedia $multimedia, MultimediaRatingTypeEnum $type, MultimediaRatingTypeEnum $oppositeType, User $owner): MultimediaRating
    {
        $multimediaRating = $this->multimediaRatingRepository->getRating($multimedia, $owner);

        if (null === $multimediaRating) {
            return $this->addMultimediaRating->process($multimedia, $type, $owner);
        }

        return $this->updateMultimediaRating->process($multimediaRating, $type, $oppositeType);
    }
}