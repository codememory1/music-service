<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Entity\Multimedia;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Multimedia\AppealCanceledService;
use App\Service\Multimedia\PublishMultimediaService;
use App\Service\Multimedia\SendOnModerationService;
use App\Service\Multimedia\UnpublishMultimediaService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaActionController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user/multimedia/{multimedia_id<\d+>}')]
#[Authorization]
#[UserRolePermission(RolePermissionEnum::MULTIMEDIA_STATUS_CONTROL_TO_USER)]
class MultimediaActionController extends AbstractRestController
{
    #[Route('/send-on-moderation', methods: 'PATCH')]
    public function sendOnModeration(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        SendOnModerationService $sendOnModerationService
    ): JsonResponse {
        return $sendOnModerationService->make($multimedia);
    }

    #[Route('/publish', methods: 'PATCH')]
    public function publish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        PublishMultimediaService $publishMultimediaService
    ): JsonResponse {
        return $publishMultimediaService->request($multimedia);
    }

    #[Route('/unpublish', methods: 'PATCH')]
    public function unpublish(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        UnpublishMultimediaService $unpublishMultimediaService
    ): JsonResponse {
        return $unpublishMultimediaService->request($multimedia);
    }

    #[Route('/appeal-canceled', methods: 'PATCH')]
    public function appealCanceled(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] Multimedia $multimedia,
        AppealCanceledService $appealCanceledService
    ): JsonResponse {
        return $appealCanceledService->request($multimedia);
    }
}