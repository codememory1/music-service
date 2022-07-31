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
use App\Service\MediaLibrary\ShareMediaLibraryWithFriendService;
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
#[Authorization]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    public function allMultimedia(MultimediaMediaLibraryResponseData $multimediaMediaLibraryResponseData): JsonResponse
    {
        $multimediaMediaLibraryResponseData->setEntities(
            $this->getAuthorizedUser()->getMediaLibrary()->getMultimedia()
        );
        $multimediaMediaLibraryResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaMediaLibraryResponseData->getResponse());
    }

    #[Route('/share/with-friend/{user_id<\d+>}', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareMediaLibraryWithFriendService $shareWithFriendMediaLibraryService
    ): JsonResponse {
        if (null === $this->getAuthorizedUser()->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        if (false === $friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

        return $shareWithFriendMediaLibraryService->request(
            $this->getAuthorizedUser()->getMediaLibrary(),
            $this->getAuthorizedUser(),
            $friend
        );
    }
}