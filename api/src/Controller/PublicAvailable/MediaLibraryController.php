<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\User;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\ResponseData\General\MediaLibrary\MediaLibraryResponseData;
use App\ResponseData\General\MediaLibrary\MediaLibraryStatisticResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use App\UseCase\MediaLibrary\ShareMediaLibraryWithFriend;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/media-library')]
#[Authorization]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/multimedia/all', methods: Request::METHOD_GET)]
    public function allMultimedia(MediaLibraryMultimediaResponseData $responseData): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $this->getAuthorizedUser()->getMediaLibrary()?->getMultimedia() ?: []);
    }

    #[Route('/share/with-friend/{user_id<\d+>}', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::SHARE_MEDIA_LIBRARY_WITH_FRIENDS)]
    public function share(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $friend,
        ShareMediaLibraryWithFriend $shareMediaLibraryWithFriend,
        MediaLibraryResponseData $responseData,
    ): HttpResponseCollectorInterface {
        if (null === $this->getAuthorizedUser()->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        if (!$friend->isFriend($this->getAuthorizedUser())) {
            throw EntityNotFoundException::friend();
        }

        return $this->responseData($responseData, $shareMediaLibraryWithFriend->process($this->getAuthorizedUser(), $friend));
    }

    #[Route('/statistic', methods: Request::METHOD_GET)]
    public function statistic(MediaLibraryStatisticResponseData $responseData): HttpResponseCollectorInterface
    {
        return $this->responseData($responseData, $this->getAuthorizedUser()->getMediaLibrary()?->getStatistic() ?: []);
    }
}