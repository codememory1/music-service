<?php

namespace App\UseCase\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaAudition;
use App\Entity\User;
use App\Infrastructure\Doctrine\Flusher;
use App\Repository\MultimediaAuditionRepository;

final class AddMultimediaListener
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly MultimediaAuditionRepository $multimediaAuditionRepository
    ) {
    }

    public function process(Multimedia $multimedia, User $listener): ?MultimediaAudition
    {
        $finedMultimediaAudition = $this->multimediaAuditionRepository->findByMultimediaAndUser($multimedia, $listener);

        if (null === $finedMultimediaAudition && false === $multimedia->getUser()->isCompare($listener)) {
            $multimediaAudition = new MultimediaAudition();

            $multimediaAudition->setUser($listener);
            $multimediaAudition->setMultimedia($multimedia);

            $this->flusher->save($multimediaAudition);

            return $multimediaAudition;
        }

        return null;
    }
}