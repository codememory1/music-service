<?php

namespace App\Controller\PublicAvailable;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\SubscriptionPermission;
use App\Entity\Multimedia;
use App\Enum\SubscriptionPermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Multimedia\AddMultimediaToMediaLibraryService;
use App\Service\Multimedia\SendOnAppealService;
use App\Service\Multimedia\SendOnModerationService;
use App\Service\Multimedia\SetDisLikeMultimediaService;
use App\Service\Multimedia\SetLikeMultimediaService;
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
        AddMultimediaToMediaLibraryService $addMultimediaToMediaLibraryService
    ): JsonResponse {
        if (false === $multimedia->isPublished()) {
            throw EntityNotFoundException::multimedia();
        }

        return $addMultimediaToMediaLibraryService->request($multimedia, $this->getAuthorizedUser());
    }

    #[Route('/send-on-moderation', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnModerationService $sendOnModerationService
    ): JsonResponse {
        if (false === $this->getAuthorizedUser()->isMultimediaBelongs($multimedia)) {
            throw EntityNotFoundException::multimedia();
        }

        return $sendOnModerationService->make($multimedia);
    }

    #[Route('/send-on-appeal', methods: 'PATCH')]
    #[SubscriptionPermission(SubscriptionPermissionEnum::ADD_MULTIMEDIA)]
    public function sendOnAppeal(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnAppealService $sendOnAppealService
    ): JsonResponse {
        return $sendOnAppealService->request($multimedia);
    }

    #[Route('/like', methods: 'PATCH')]
    public function like(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SetLikeMultimediaService $setLikeMultimediaService
    ): JsonResponse {
        return $setLikeMultimediaService->request($multimedia, $this->getAuthorizedUser());
    }

    #[Route('/dislike', methods: 'PATCH')]
    public function dislike(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SetDisLikeMultimediaService $setDisLikeMultimediaService
    ): JsonResponse {
        return $setDisLikeMultimediaService->request($multimedia, $this->getAuthorizedUser());
    }
}