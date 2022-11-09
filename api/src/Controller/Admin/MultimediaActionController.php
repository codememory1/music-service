<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\Multimedia;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Multimedia\MultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Multimedia\AppealCanceled;
use App\Service\Multimedia\PublishMultimedia;
use App\Service\Multimedia\SendOnModeration;
use App\Service\Multimedia\UnpublishMultimedia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia/{multimedia_id<\d+>}')]
#[Authorization]
#[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
class MultimediaActionController extends AbstractRestController
{
    #[Route('/send-on-moderation', methods: 'PATCH')]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnModeration $sendOnModeration,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($sendOnModeration->sendOnModeration($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/publish', methods: 'PATCH')]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        PublishMultimedia $publishMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($publishMultimedia->publish($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/unpublish', methods: 'PATCH')]
    public function unpublish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        UnpublishMultimedia $unpublishMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($unpublishMultimedia->unpublish($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/appeal-canceled', methods: 'PATCH')]
    public function appealCanceled(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AppealCanceled $appealCanceled,
        MultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($appealCanceled->appeal($multimedia));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}