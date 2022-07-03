<?php

namespace App\Service\MediaLibrary;

use App\Entity\MultimediaMediaLibrary;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class DeleteMultimediaMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class DeleteMultimediaMediaLibraryService extends AbstractService
{
    public function make(MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $this->em->remove($multimediaMediaLibrary);
        $this->em->flush();

        return $this->responseCollection->successDelete('multimediaMediaLibrary@successDelete');
    }
}