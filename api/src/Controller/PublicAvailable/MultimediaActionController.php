<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Multimedia;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Multimedia\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Multimedia\AddMultimediaToMediaLibrary;
use App\Service\Multimedia\SendOnAppeal;
use App\Service\Multimedia\SendOnModeration;
use App\Service\Multimedia\ToggleDislikeMultimedia;
use App\Service\Multimedia\ToggleLikeMultimedia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia/{multimedia_id<\d+>}')]
#[Authorization]
class MultimediaActionController extends AbstractRestController
{
    #[Route('/add-to-media-library', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function addToMediaLibrary(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AddMultimediaToMediaLibrary $addMultimediaToMediaLibrary,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $multimedia->isPublished()) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($addMultimediaToMediaLibrary->add($multimedia, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/send-on-moderation', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnModeration $sendOnModeration,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($sendOnModeration->sendOnModeration($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/send-on-appeal', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnAppeal(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnAppeal $sendOnAppeal,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($sendOnAppeal->sendOnAppeal($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/like', methods: 'PATCH')]
    public function like(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleLikeMultimedia $setLikeMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($setLikeMultimedia->toggle($multimedia, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/dislike', methods: 'PATCH')]
    public function dislike(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleDislikeMultimedia $setDisLikeMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($setDisLikeMultimedia->toggle($multimedia, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}