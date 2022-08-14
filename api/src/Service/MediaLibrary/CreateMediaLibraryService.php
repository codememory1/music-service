<?php

namespace App\Service\MediaLibrary;

use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\CreateMediaLibraryEvent;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

class CreateMediaLibraryService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function create(MediaLibraryDto $mediaLibraryDto, User $forUser): MediaLibrary
    {
        $this->validate($mediaLibraryDto);

        $mediaLibrary = $mediaLibraryDto->getEntity();

        if (null !== $forUser->getMediaLibrary()) {
            throw EntityExistException::mediaLibrary();
        }

        $mediaLibrary->setUser($forUser);

        $this->flusherService->save($mediaLibrary);

        $this->eventDispatcher->dispatch(
            new CreateMediaLibraryEvent($mediaLibrary),
            EventEnum::CREATE_MEDIA_LIBRARY->value
        );

        return $mediaLibrary;
    }

    public function request(MediaLibraryDto $mediaLibraryDto, User $forUser): JsonResponse
    {
        $this->create($mediaLibraryDto, $forUser);

        return $this->responseCollection->successCreate('mediaLibrary@successCreate');
    }
}