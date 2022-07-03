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
    /**
     * @param MediaLibraryDTO $mediaLibraryDTO
     *
     * @return JsonResponse
     */
    public function make(MediaLibraryDTO $mediaLibraryDTO): JsonResponse
    {
        if (false === $this->validate($mediaLibraryDTO)) {
            return $this->validator->getResponse();
        }

        $this->em->flush();

        return $this->responseCollection->successUpdate('mediaLibrary@successUpdate');
    }
}