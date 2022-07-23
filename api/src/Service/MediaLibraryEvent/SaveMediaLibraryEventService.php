<?php

namespace App\Service\MediaLibraryEvent;

use App\DTO\MediaLibraryEventDTO;
use App\Entity\MediaLibrary;
use App\Entity\MediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class SaveMediaLibraryEventService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  Codememory
 */
class SaveMediaLibraryEventService extends AbstractService
{
    #[Required]
    public ?EventPayloadHandlerService $eventPayloadHandlerService = null;

    public function make(MediaLibraryEventDTO $mediaLibraryEventDTO, MediaLibrary $mediaLibrary, MediaLibraryEvent $mediaLibraryEvent): void
    {
        $this->eventPayloadHandlerService->handler($mediaLibraryEventDTO, $mediaLibrary);

        if (null === $mediaLibraryEvent->getId()) {
            $this->em->persist($mediaLibraryEvent);
        }

        $this->em->flush();
    }
}