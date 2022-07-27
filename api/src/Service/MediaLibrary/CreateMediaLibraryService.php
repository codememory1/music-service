<?php

namespace App\Service\MediaLibrary;

use App\DTO\MediaLibraryDTO;
use App\Entity\User;
use App\Rest\Http\Exceptions\EntityExistException;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class CreateMediaLibraryService.
 *
 * @package App\Service\MediaLibrary
 *
 * @author  Codememory
 */
class CreateMediaLibraryService extends AbstractService
{
    #[Required]
    public ?SaveMediaLibraryService $saveMediaLibraryService = null;

    public function make(MediaLibraryDTO $mediaLibraryDTO, User $forUser): JsonResponse
    {
        if (false === $this->validate($mediaLibraryDTO)) {
            return $this->validator->getResponse();
        }

        if (null !== $forUser->getMediaLibrary()) {
            throw EntityExistException::mediaLibrary();
        }

        $this->saveMediaLibraryService->make($mediaLibraryDTO->getEntity(), $forUser);

        return $this->responseCollection->successCreate('mediaLibrary@successCreate');
    }
}