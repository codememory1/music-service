<?php

namespace App\Service\MediaLibrary;

use App\Dto\Transfer\MediaLibraryDto;
use App\Entity\MediaLibrary;
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
    public function update(MediaLibraryDto $mediaLibraryDto): MediaLibrary
    {
        $this->validate($mediaLibraryDto);

        $this->flusherService->save();

        return $mediaLibraryDto->getEntity();
    }

    public function request(MediaLibraryDto $mediaLibraryDto): JsonResponse
    {
        $this->update($mediaLibraryDto);

        return $this->responseCollection->successUpdate('mediaLibrary@successUpdate');
    }
}