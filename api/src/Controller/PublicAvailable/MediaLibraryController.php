<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MultimediaMediaLibraryDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\MultimediaMediaLibraryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\DeleteMultimediaMediaLibraryService;
use App\Service\MediaLibrary\ShareWithFriendMultimediaMediaLibraryService;
use App\Service\MediaLibrary\UpdateMultimediaMediaLibraryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaLibraryController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library')]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    #[Authorization]
    public function allMultimedia(MultimediaMediaLibraryResponseData $multimediaMediaLibraryResponseData): JsonResponse
    {
        $multimediaToMediaLibrary = $this->authorizedUser->getUser()->getMediaLibrary()->getMultimedia();

        $multimediaMediaLibraryResponseData->setEntities($multimediaToMediaLibrary->toArray());
        $multimediaMediaLibraryResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaMediaLibraryResponseData->getResponse());
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function updateMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryDTO $multimediaMediaLibraryDTO,
        UpdateMultimediaMediaLibraryService $updateMultimediaMediaLibraryService
    ): JsonResponse {
        if ($multimediaMediaLibrary->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::multimedia();
        }

        $multimediaMediaLibraryDTO->setEntity($multimediaMediaLibrary);

        return $updateMultimediaMediaLibraryService->make($multimediaMediaLibraryDTO->collect());
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibraryService $deleteMultimediaMediaLibraryService
    ): JsonResponse {
        if ($multimediaMediaLibrary->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::multimedia();
        }

        return $deleteMultimediaMediaLibraryService->make($multimediaMediaLibrary);
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/share/with-friend/{user_id<\d+>}', methods: 'PATCH')]
    #[Authorization]
//    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS)]
    public function shareMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareWithFriendMultimediaMediaLibraryService $shareWithFriendMultimediaMediaLibraryService
    ): JsonResponse {
        if ($multimediaMediaLibrary->getMediaLibrary() !== $this->authorizedUser->getUser()->getMediaLibrary()) {
            throw EntityNotFoundException::multimedia();
        }

        if (false === $friend->isFriend($this->authorizedUser->getUser())) {
            throw EntityNotFoundException::friend();
        }

        return $shareWithFriendMultimediaMediaLibraryService->make($multimediaMediaLibrary, $friend);
    }
}