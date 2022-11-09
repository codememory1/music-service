<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Event\SetRatingMultimediaEvent;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\MultimediaRatingRepository;
use function call_user_func;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class ToggleRatingMultimedia
{
    public function __construct(
        private readonly MultimediaRatingRepository $multimediaRatingRepository,
        private readonly Flusher $flusher,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function toggle(
        Multimedia $multimedia,
        User $from,
        MultimediaRatingTypeEnum $type,
        MultimediaRatingTypeEnum $oppositeType,
        callable $callbackRemove
    ): void {
        $multimediaRating = $this->multimediaRatingRepository->getRating($multimedia, $from);

        if (null === $multimediaRating) {
            $multimediaRating = $this->addRating($multimedia, $from, $type);
        } else {
            $this->updateRating($multimediaRating, $type, $oppositeType, $callbackRemove);
        }

        $this->flusher->save();

        $this->eventDispatcher->dispatch(new SetRatingMultimediaEvent($multimediaRating));
    }

    private function addRating(Multimedia $multimedia, User $from, MultimediaRatingTypeEnum $type): MultimediaRating
    {
        $multimediaRating = new MultimediaRating();

        $multimediaRating->setMultimedia($multimedia);
        $multimediaRating->setUser($from);
        $multimediaRating->setType($type);

        $multimedia->addRating($multimediaRating);

        return $multimediaRating;
    }

    private function updateRating(
        MultimediaRating $multimediaRating,
        MultimediaRatingTypeEnum $type,
        MultimediaRatingTypeEnum $oppositeType,
        callable $callbackRemove
    ): void {
        if ($multimediaRating->getType() === $oppositeType->name) {
            $multimediaRating->setType($type);
        } else {
            $this->flusher->remove($multimediaRating);

            call_user_func($callbackRemove, $multimediaRating);
        }
    }
}