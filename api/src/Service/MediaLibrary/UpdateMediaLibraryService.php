<?php

namespace App\Service\MediaLibrary;

use App\DTO\MediaLibraryDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UpdateMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class UpdateMediaLibraryService extends AbstractService
{
    public function make(MediaLibraryDTO $mediaLibraryDTO): JsonResponse
    {
        if (false === $this->validate($mediaLibraryDTO)) {
            return $this->validator->getResponse();
        }

        $this->flusherService->save();

        return $this->responseCollection->successUpdate('mediaLibrary@successUpdate');
    }
}