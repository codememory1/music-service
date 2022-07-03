<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Multimedia;
use App\Enum\MultimediaStatusEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Multimedia\AddMultimediaToMediaLibraryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaActionController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/multimedia/{multimedia_id<\d+>}')]
class MultimediaActionController extends AbstractRestController
{
    #[Route('/add-to-media-library', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function addToMediaLibrary(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AddMultimediaToMediaLibraryService $addMultimediaToMediaLibraryService
    ): JsonResponse {
        if ($multimedia->getStatus() !== MultimediaStatusEnum::PUBLISHED->name) {
            throw EntityNotFoundException::multimedia();
        }

        return $addMultimediaToMediaLibraryService->make($multimedia, $this->authorizedUser->getUser());
    }
}