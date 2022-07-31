<?php

namespace App\Service\MediaLibraryEvent;

use App\Entity\MediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteMediaLibraryEventService.
 *
 * @package App\Service\MediaLibraryEvent
 *
 * @author  Codememory
 */
class DeleteMediaLibraryEventService extends AbstractService
{
    public function delete(MediaLibraryEvent $mediaLibraryEvent): MediaLibraryEvent
    {
        $this->flusherService->remove($mediaLibraryEvent);

        return $mediaLibraryEvent;
    }

    public function request(MediaLibraryEvent $mediaLibraryEvent): JsonResponse
    {
        $this->delete($mediaLibraryEvent);

        return $this->responseCollection->successCreate('event@successDelete');
    }
}