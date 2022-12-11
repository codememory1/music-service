<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Multimedia;
use App\Enum\PlatformCodeEnum;
use App\Enum\SubscriptionPermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Multimedia\MultimediaRatingResponseData;
use App\ResponseData\General\Multimedia\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Multimedia\Action\AddMultimediaToMediaLibrary;
use App\UseCase\Multimedia\Action\SendMultimediaOnAppeal;
use App\UseCase\Multimedia\Action\SendMultimediaOnModeration;
use App\UseCase\Multimedia\Action\ToggleMultimediaDislike;
use App\UseCase\Multimedia\Action\ToggleMultimediaLike;
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

        $responseData->setEntities($addMultimediaToMediaLibrary->process($multimedia, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/send-on-moderation', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendMultimediaOnModeration $sendMultimediaOnModeration,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        $responseData->setEntities($sendMultimediaOnModeration->process($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/send-on-appeal', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnAppeal(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendMultimediaOnAppeal $sendMultimediaOnAppeal,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($sendMultimediaOnAppeal->process($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/like', methods: 'PATCH')]
    public function like(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleMultimediaLike $toggleMultimediaLike,
        MultimediaRatingResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($toggleMultimediaLike->process($multimedia, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/dislike', methods: 'PATCH')]
    public function dislike(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleMultimediaDislike $toggleMultimediaDislike,
        MultimediaRatingResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($toggleMultimediaDislike->process($multimedia, $this->getAuthorizedUser()));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}