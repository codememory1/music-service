<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;
use App\Enum\MultimediaRatingTypeEnum;
use App\Event\SetRatingMultimediaEvent;
use App\Service\FlusherService;
use Doctrine\ORM\EntityManagerInterface;
use function call_user_func;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class SaveMultimediaRatingService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly FlusherService $flusherService,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    public function make(
        Multimedia $multimedia,
        User $fromUser,
        MultimediaRatingTypeEnum $typeEnum,
        MultimediaRatingTypeEnum $oppositeTypeEnum,
        callable $callbackRemove
    ): void {
        $multimediaRatingRepository = $this->em->getRepository(MultimediaRating::class);
        $multimediaRating = $multimediaRatingRepository->getRating($multimedia, $fromUser);

        if (null === $multimediaRating) {
            $multimediaRating = $this->addRating($multimedia, $fromUser, $typeEnum);
        } else {
            $this->updateRating($multimediaRating, $typeEnum, $oppositeTypeEnum, $callbackRemove);
        }

        $this->flusherService->save();

        $this->eventDispatcher->dispatch(new SetRatingMultimediaEvent($multimediaRating));
    }

    private function addRating(Multimedia $multimedia, User $fromUser, MultimediaRatingTypeEnum $typeEnum): MultimediaRating
    {
        $multimediaRating = new MultimediaRating();

        $multimediaRating->setMultimedia($multimedia);
        $multimediaRating->setUser($fromUser);
        $multimediaRating->setType($typeEnum);

        $multimedia->addRating($multimediaRating);

        return $multimediaRating;
    }

    private function updateRating(
        MultimediaRating $multimediaRating,
        MultimediaRatingTypeEnum $typeEnum,
        MultimediaRatingTypeEnum $oppositeTypeEnum,
        callable $callbackRemove
    ): void {
        if ($multimediaRating->getType() === $oppositeTypeEnum->name) {
            $multimediaRating->setType($typeEnum);
        } else {
            $this->em->remove($multimediaRating);

            call_user_func($callbackRemove, $multimediaRating);
        }
    }
}