<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\NotificationTransformer;
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
#[Authorization]
class NotificationController extends AbstractRestController
{
    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_NOTIFICATION)]
    public function create(NotificationTransformer $notificationTransformer, CreateNotificationService $createNotificationService): JsonResponse
    {
        return $createNotificationService->request($notificationTransformer->transformFromRequest(), $this->getAuthorizedUser());
    }
}