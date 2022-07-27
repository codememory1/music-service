<?php

namespace App\Service\MediaLibrary;

use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\EventEnum;
use App\Event\CreateMediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class SaveMediaLibraryService extends AbstractService
{
    #[Required]
    public ?EventDispatcherInterface $eventDispatcher = null;

    public function make(MediaLibrary $mediaLibrary, User $forUser): void
    {
        $forUser->setMediaLibrary($mediaLibrary);

        $this->flusherService->save();

        $this->eventDispatcher->dispatch(
            new CreateMediaLibraryEvent($forUser->getMediaLibrary()),
            EventEnum::CREATE_MEDIA_LIBRARY->value
        );
    }
}