<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\DTO\MultimediaMediaLibraryDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\DeleteMultimediaMediaLibraryService;
use App\Service\MediaLibrary\ShareWithFriendMultimediaMediaLibraryService;
use App\Service\MediaLibrary\UpdateMultimediaMediaLibraryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaMediaLibraryController.
 *
 * @package App\Controller\PublicAvailable
 *
 * @author  Codememory
 */
#[Route('/user/media-library')]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function update(
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
    public function delete(
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
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareWithFriendMultimediaMediaLibraryService $shareWithFriendMultimediaMediaLibraryService
    ): JsonResponse {
        $authorizedUser = $this->authorizedUser->getUser();

        if ($multimediaMediaLibrary->getMediaLibrary() !== $authorizedUser->getMediaLibrary()) {
            throw EntityNotFoundException::multimedia();
        }

        if (false === $friend->isFriend($authorizedUser)) {
            throw EntityNotFoundException::friend();
        }

        return $shareWithFriendMultimediaMediaLibraryService->make($multimediaMediaLibrary, $authorizedUser, $friend);
    }
}