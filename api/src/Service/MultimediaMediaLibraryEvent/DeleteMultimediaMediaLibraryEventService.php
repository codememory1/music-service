<?php

namespace App\Service\MultimediaMediaLibraryEvent;

use App\Entity\MultimediaMediaLibraryEvent;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteMultimediaMediaLibraryEventService.
 *
 * @package App\Service\MultimediaMediaLibraryEvent
 *
 * @author  Codememory
 */
class DeleteMultimediaMediaLibraryEventService extends AbstractService
{
    public function make(MultimediaMediaLibraryEvent $multimediaMediaLibraryEvent): JsonResponse
    {
        $this->em->remove($multimediaMediaLibraryEvent);
        $this->em->flush();

        return $this->responseCollection->successCreate('event@successDelete');
    }
}