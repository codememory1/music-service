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
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        $multimediaMediaLibraryDTO->setEntity($multimediaMediaLibrary);
        $multimediaMediaLibraryDTO->collect();

        return $updateMultimediaMediaLibraryService->make($multimediaMediaLibraryDTO);
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibraryService $deleteMultimediaMediaLibraryService
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

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
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        if (false === $friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

        return $shareWithFriendMultimediaMediaLibraryService->make($multimediaMediaLibrary, $this->getAuthorizedUser(), $friend);
    }

    private function throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser(MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}