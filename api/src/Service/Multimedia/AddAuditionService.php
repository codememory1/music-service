<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaAudition;
use App\Entity\User;
use App\Repository\MultimediaAuditionRepository;
use App\Service\FlusherService;

final class AddAuditionService
{
    private FlusherService $flusherService;
    private MultimediaAuditionRepository $multimediaAuditionRepository;

    public function __construct(FlusherService $flusherService, MultimediaAuditionRepository $multimediaAuditionRepository)
    {
        $this->flusherService = $flusherService;
        $this->multimediaAuditionRepository = $multimediaAuditionRepository;
    }

    public function add(Multimedia $multimedia, User $listen): Multimedia
    {
        if (null === $this->multimediaAuditionRepository->findByMultimediaAndUser($multimedia, $listen)) {
            $multimediaAudition = new MultimediaAudition();

            $multimediaAudition->setUser($listen);

            $multimedia->addAudition($multimediaAudition);

            $this->flusherService->save($multimediaAudition);
        }

        return $multimedia;
    }
}