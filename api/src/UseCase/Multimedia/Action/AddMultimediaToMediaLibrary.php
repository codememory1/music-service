<?php

namespace App\UseCase\Multimedia\Action;

use App\Entity\Multimedia;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Exception\Http\EntityNotFoundException;
use App\Infrastructure\Doctrine\Flusher;
use App\Infrastructure\Validator\Validator;

final class AddMultimediaToMediaLibrary
{
    public function __construct(
        private readonly Flusher $flusher,
        private readonly Validator $validator
    ) {
    }

    public function process(Multimedia $multimedia, User $to): Multimedia
    {
        $this->throwIfNotMediaLibrary($to);

        $multimediaMediaLibrary = new MultimediaMediaLibrary();

        $multimediaMediaLibrary->setMediaLibrary($to->getMediaLibrary());
        $multimediaMediaLibrary->setMultimedia($multimedia);

        $this->validator->validate($multimediaMediaLibrary);

        $this->flusher->save($multimediaMediaLibrary);

        return $multimedia;
    }

    private function throwIfNotMediaLibrary(User $user): void
    {
        if (null === $user->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }
    }
}