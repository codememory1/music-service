<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\Multimedia;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
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
        SendOnModeration $sendOnModerationService
    ): JsonResponse {
        return $sendOnModerationService->make($multimedia);
    }

    #[Route('/publish', methods: 'PATCH')]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        PublishMultimedia $publishMultimediaService
    ): JsonResponse {
        return $publishMultimediaService->request($multimedia);
    }

    #[Route('/unpublish', methods: 'PATCH')]
    public function unpublish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        UnpublishMultimedia $unpublishMultimediaService
    ): JsonResponse {
        return $unpublishMultimediaService->request($multimedia);
    }

    #[Route('/appeal-canceled', methods: 'PATCH')]
    public function appealCanceled(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AppealCanceled $appealCanceledService
    ): JsonResponse {
        return $appealCanceledService->request($multimedia);
    }
}