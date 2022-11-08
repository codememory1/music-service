<?php

namespace App\Service\Multimedia;

use App\Entity\Multimedia;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;

class AddMultimediaToMediaLibrary
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator
    ) {
    }

    public function add(Multimedia $multimedia, User $to): Multimedia
    {
        if (null === $to->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $multimediaMediaLibrary = new MultimediaMediaLibrary();

        $multimediaMediaLibrary->setMediaLibrary($to->getMediaLibrary());
        $multimediaMediaLibrary->setMultimedia($multimedia);

        $this->validator->validate($multimediaMediaLibrary);

        $this->flusher->save($multimediaMediaLibrary);

        return $multimedia;
    }
}