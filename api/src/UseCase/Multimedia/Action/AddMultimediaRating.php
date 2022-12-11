<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Enum\MultimediaStatusEnum;
use App\Event\SetRatingMultimediaEvent;
use App\Exception\Http\EntityNotFoundException;
use App\Exception\Http\MultimediaException;
use App\Infrastructure\Doctrine\Flusher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AddMultimediaRating
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function process(Multimedia $multimedia, MultimediaRatingTypeEnum $type, User $owner): MultimediaRating
    {
        $this->throwIfNotPublishedMultimedia($multimedia, $owner);

        $multimediaRating = new MultimediaRating();

        $multimediaRating->setMultimedia($multimedia);
        $multimediaRating->setUser($owner);
        $multimediaRating->setType($type);

        $multimedia->addRating($multimediaRating);

        $this->flusher->save();

        $this->eventDispatcher->dispatch(new SetRatingMultimediaEvent($multimediaRating));

        return $multimediaRating;
    }

    private function throwIfNotPublishedMultimedia(Multimedia $multimedia, User $owner): void
    {
        if ($multimedia->getStatus() !== MultimediaStatusEnum::PUBLISHED->name) {
            if ($multimedia->getUser()->isCompare($owner)) {
                throw MultimediaException::badAddRatingToNotPublishedMultimedia();
            }

            throw EntityNotFoundException::multimedia();
        }
    }
}