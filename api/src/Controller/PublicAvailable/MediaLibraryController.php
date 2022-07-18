<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\ResponseData\MultimediaMediaLibraryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\ShareWithFriendMediaLibraryService;
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

    #[Route('/share/with-friend/{user_id<\d+>}', methods: 'PATCH')]
    #[Authorization]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareWithFriendMediaLibraryService $shareWithFriendMediaLibraryService
    ): JsonResponse {
        $authorizedUser = $this->authorizedUser->getUser();

        if (null === $authorizedUser->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        if (false === $friend->isFriend($authorizedUser)) {
            throw EntityNotFoundException::friend();
        }

        return $shareWithFriendMediaLibraryService->make($authorizedUser->getMediaLibrary(), $authorizedUser, $friend);
    }
}