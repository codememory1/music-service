<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\MultimediaRating;
use App\Enum\MultimediaRatingTypeEnum;
use App\Event\SetRatingMultimediaEvent;
use App\Infrastructure\Doctrine\Flusher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class UpdateMultimediaRating
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function process(MultimediaRating $multimediaRating, MultimediaRatingTypeEnum $type, MultimediaRatingTypeEnum $oppositeType): MultimediaRating
    {
        if ($multimediaRating->getType() === $oppositeType->name) {
            $multimediaRating->setType($type);

            $this->flusher->save();
        } else {
            $this->flusher->remove($multimediaRating);
        }

        $this->eventDispatcher->dispatch(new SetRatingMultimediaEvent($multimediaRating));

        return $multimediaRating;
    }
}