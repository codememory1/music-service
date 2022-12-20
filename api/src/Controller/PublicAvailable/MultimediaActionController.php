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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia/{multimedia_id<\d+>}')]
#[Authorization]
class MultimediaActionController extends AbstractRestController
{
    #[Route('/add-to-media-library', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA_TO_MEDIA_LIBRARY)]
    public function addToMediaLibrary(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AddMultimediaToMediaLibrary $addMultimediaToMediaLibrary,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (!$multimedia->isPublished()) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData(
            $responseData,
            $addMultimediaToMediaLibrary->process($multimedia, $this->getAuthorizedUser()),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/send-on-moderation', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendMultimediaOnModeration $sendMultimediaOnModeration,
        MultimediaResponseData $responseData
    ): JsonResponse {
        if (!$this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        return $this->responseData($responseData, $sendMultimediaOnModeration->process($multimedia), PlatformCodeEnum::UPDATED);
    }

    #[Route('/send-on-appeal', methods: Request::METHOD_PATCH)]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnAppeal(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendMultimediaOnAppeal $sendMultimediaOnAppeal,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $sendMultimediaOnAppeal->process($multimedia), PlatformCodeEnum::UPDATED);
    }

    #[Route('/like', methods: Request::METHOD_PATCH)]
    public function like(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleMultimediaLike $toggleMultimediaLike,
        MultimediaRatingResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $toggleMultimediaLike->process($multimedia, $this->getAuthorizedUser()),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/dislike', methods: Request::METHOD_PATCH)]
    public function dislike(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        ToggleMultimediaDislike $toggleMultimediaDislike,
        MultimediaRatingResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $toggleMultimediaDislike->process($multimedia, $this->getAuthorizedUser()),
            PlatformCodeEnum::UPDATED
        );
    }
}