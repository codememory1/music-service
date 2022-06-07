<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\DTO\NotificationDTO;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\Notification\CreateNotificationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NotificationController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/notification')]
class NotificationController extends AbstractRestController
{
    /**
     * @param NotificationDTO           $notificationDTO
     * @param CreateNotificationService $createNotificationService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_NOTIFICATION)]
    public function create(NotificationDTO $notificationDTO, CreateNotificationService $createNotificationService): JsonResponse
    {
        return $createNotificationService->make($notificationDTO->collect(), $this->authorizedUser->getUser());
    }
}