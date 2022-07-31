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
    public function delete(MultimediaMediaLibrary $multimediaMediaLibrary): MultimediaMediaLibrary
    {
        $this->flusherService->remove($multimediaMediaLibrary);

        return $multimediaMediaLibrary;
    }

    public function request(MultimediaMediaLibrary $multimediaMediaLibrary): JsonResponse
    {
        $this->delete($multimediaMediaLibrary);

        return $this->responseCollection->successDelete('multimediaMediaLibrary@successDelete');
    }
}