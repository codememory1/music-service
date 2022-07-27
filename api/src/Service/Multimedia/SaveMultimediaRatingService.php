<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaRating;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Enum\MultimediaRatingTypeEnum;
use App\Event\SetRatingMultimediaEvent;
use App\Service\AbstractService;
use function call_user_func;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveMultimediaRatingService.
 *
 * @package App\Service\Multimedia
 *
 * @author  Codememory
 */
class SaveMultimediaRatingService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

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
            $multimediaRating = new MultimediaRating();

            $multimediaRating->setMultimedia($multimedia);
            $multimediaRating->setUser($fromUser);
            $multimediaRating->setType($typeEnum);

            $multimedia->addRating($multimediaRating);
        } else {
            if ($multimediaRating->getType() === $oppositeTypeEnum->name) {
                $multimediaRating->setType($typeEnum);
            } else {
                $this->em->remove($multimediaRating);

                call_user_func($callbackRemove, $multimediaRating);
            }
        }

        $this->flusherService->save();

        $this->eventDispatcher->dispatch(
            new SetRatingMultimediaEvent($multimediaRating),
            EventEnum::SET_RATING_MULTIMEDIA->value
        );
    }
}