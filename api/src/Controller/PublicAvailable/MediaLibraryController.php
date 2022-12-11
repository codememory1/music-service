<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\ResponseData\General\MediaLibrary\MediaLibraryStatisticResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\MediaLibrary\ShareMediaLibraryWithFriend;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: 'GET')]
    public function allMultimedia(MediaLibraryMultimediaResponseData $responseData): JsonResponse
    {
        $responseData->setEntities(
            $this->getAuthorizedUser()->getMediaLibrary()?->getMultimedia() ?: []
        );

        return $this->responseData($responseData);
    }

    #[Route('/share/with-friend/{user_id<\d+>}', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareMediaLibraryWithFriend $shareMediaLibraryWithFriend
    ): JsonResponse {
        if (null === $this->getAuthorizedUser()->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        if (false === $friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

//        return $shareMediaLibraryWithFriendService->share(
//            $this->getAuthorizedUser()->getMediaLibrary(),
//            $this->getAuthorizedUser(),
//            $friend
//        );
        return $this->response([1]);
    }

    #[Route('/statistic', methods: 'GET')]
    public function statistic(MediaLibraryStatisticResponseData $responseData): JsonResponse
    {
        $mediaLibrary = $this->getAuthorizedUser()->getMediaLibrary();

        $responseData->setEntities($mediaLibrary?->getStatistic() ?: []);

        return $this->responseData($responseData);
    }
}