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
    public function make(MediaLibraryEvent $mediaLibraryEvent): JsonResponse
    {
        $this->em->remove($mediaLibraryEvent);
        $this->em->flush();

        return $this->responseCollection->successCreate('event@successDelete');
    }
}