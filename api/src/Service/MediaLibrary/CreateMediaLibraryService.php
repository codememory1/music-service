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

/**
 * Class CreateMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
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

        $forUser->setMediaLibrary($mediaLibrary);

        $this->eventDispatcher->dispatch(
            new CreateMediaLibraryEvent($forUser->getMediaLibrary()),
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