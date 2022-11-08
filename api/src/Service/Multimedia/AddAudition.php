<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaAudition;
use App\Entity\User;
use App\Repository\MultimediaAuditionRepository;
use App\Service\FlusherService;

final class AddAudition
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly MultimediaAuditionRepository $multimediaAuditionRepository
    ) {
    }

    public function add(Multimedia $multimedia, User $listener): Multimedia
    {
        if (null === $this->multimediaAuditionRepository->findByMultimediaAndUser($multimedia, $listener)) {
            $multimediaAudition = new MultimediaAudition();

            $multimediaAudition->setUser($listener);
            $multimediaAudition->setMultimedia($multimedia);

            $this->flusher->save($multimediaAudition);
        }

        return $multimedia;
    }
}