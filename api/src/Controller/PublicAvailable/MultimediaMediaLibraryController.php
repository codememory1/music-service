<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Dto\Transformer\MultimediaMediaLibraryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\DeleteMultimediaMediaLibraryService;
use App\Service\MultimediaMediaLibrary\ShareMultimediaMediaLibraryWithFriendService;
use App\Service\MultimediaMediaLibrary\UpdateMultimediaMediaLibraryService;
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
#[Authorization]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::UPDATE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryTransformer $multimediaMediaLibraryTransformer,
        UpdateMultimediaMediaLibraryService $updateMultimediaMediaLibraryService
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        return $updateMultimediaMediaLibraryService->request(
            $multimediaMediaLibraryTransformer->transformFromRequest($multimediaMediaLibrary)
        );
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::DELETE_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibraryService $deleteMultimediaMediaLibraryService
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        return $deleteMultimediaMediaLibraryService->request($multimediaMediaLibrary);
    }

    #[Route('/multimedia/{multimediaMediaLibrary_id<\d+>}/share/with-friend/{user_id<\d+>}', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MULTIMEDIA_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareMultimediaMediaLibraryWithFriendService $shareWithFriendMultimediaMediaLibraryService
    ): JsonResponse {
        $this->throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser($multimediaMediaLibrary);

        if (false === $friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

        return $shareWithFriendMultimediaMediaLibraryService->request(
            $multimediaMediaLibrary,
            $this->getAuthorizedUser(),
            $friend
        );
    }

    private function throwIfMultimediaMediaLibraryNotBelongsAuthorizedUser(MultimediaMediaLibrary $multimediaMediaLibrary): void
    {
        if (false === $this->getAuthorizedUser()->isMultimediaMediaLibraryBelongs($multimediaMediaLibrary)) {
            throw EntityNotFoundException::multimedia();
        }
    }
}