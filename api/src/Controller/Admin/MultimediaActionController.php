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
use App\UseCase\Multimedia\Action\PublishMultimedia;
use App\UseCase\Multimedia\Action\SendMultimediaOnAppeal;
use App\UseCase\Multimedia\Action\SendMultimediaOnModeration;
use App\UseCase\Multimedia\Action\UnpublishMultimedia;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/multimedia/{multimedia_id<\d+>}')]
#[Authorization]
#[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
class MultimediaActionController extends AbstractRestController
{
    #[Route('/send-on-moderation', methods: Request::METHOD_PATCH)]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendMultimediaOnModeration $sendMultimediaOnModeration,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $sendMultimediaOnModeration->process($multimedia), PlatformCodeEnum::UPDATED);
    }

    #[Route('/publish', methods: Request::METHOD_PATCH)]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        PublishMultimedia $publishMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $publishMultimedia->process($multimedia), PlatformCodeEnum::UPDATED);
    }

    #[Route('/unpublish', methods: Request::METHOD_PATCH)]
    public function unpublish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        UnpublishMultimedia $unpublishMultimedia,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $unpublishMultimedia->process($multimedia), PlatformCodeEnum::UPDATED);
    }

    #[Route('/appeal-canceled', methods: Request::METHOD_PATCH)]
    public function appealCanceled(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendMultimediaOnAppeal $sendMultimediaOnAppeal,
        MultimediaResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $sendMultimediaOnAppeal->process($multimedia), PlatformCodeEnum::UPDATED);
    }
}