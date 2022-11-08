<?php

namespace App\Service\MediaLibrary;

use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Event\CreateMediaLibraryEvent;
use App\Exception\Http\EntityExistException;
use App\Infrastructure\Validator\Validator;
use App\Service\FlusherService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateMediaLibrary
{
    public function __construct(
        private readonly FlusherService $flusher,
        private readonly Validator $validator,
        private readonly EventDispatcherInterface $eventDispatcher
    ) {
    }

    public function create(MediaLibraryDto $dto, User $owner): MediaLibrary
    {
        $this->validator->validate($dto);

        $mediaLibrary = $dto->getEntity();

        if (null !== $owner->getMediaLibrary()) {
            throw EntityExistException::mediaLibrary();
        }

        $mediaLibrary->setUser($owner);

        $this->flusher->save($mediaLibrary);

        $this->eventDispatcher->dispatch(new CreateMediaLibraryEvent($mediaLibrary));

        return $mediaLibrary;
    }
}