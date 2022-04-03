<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\SubscriptionPermissionDTO;
use App\Entity\SubscriptionPermission;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Subscription\Permission\CreatorPermissionService;
use App\Service\Subscription\Permission\DeleterPermissionService;
use App\Service\Subscription\Permission\UpdaterPermissionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionPermissionController.
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
#[Route('/subscription/permission')]
class SubscriptionPermissionController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::SHOW_SUBSCRIPTION_PERMISSIONS)]
    public function all(): JsonResponse
    {
        return $this->showAllFromDatabase(
            SubscriptionPermission::class,
            SubscriptionPermissionDTO::class
        );
    }

    /**
     * @param CreatorPermissionService $creatorPermissionService
     * @param Request                  $request
     *
     * @throws UndefinedClassForDTOException
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_SUBSCRIPTION_PERMISSION)]
    public function create(CreatorPermissionService $creatorPermissionService, Request $request): JsonResponse
    {
        return $creatorPermissionService
            ->create(new SubscriptionPermissionDTO($request, $this->managerRegistry))
            ->make();
    }

    /**
     * @param UpdaterPermissionService $updaterPermissionService
     * @param Request                  $request
     * @param int                      $id
     *
     * @throws UndefinedClassForDTOException
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_SUBSCRIPTION_PERMISSION)]
    public function update(UpdaterPermissionService $updaterPermissionService, Request $request, int $id): JsonResponse
    {
        return $updaterPermissionService
            ->update(new SubscriptionPermissionDTO($request, $this->managerRegistry), $id)
            ->make();
    }

    /**
     * @param DeleterPermissionService $deleterPermissionService
     * @param int                      $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_SUBSCRIPTION_PERMISSION)]
    public function delete(DeleterPermissionService $deleterPermissionService, int $id): JsonResponse
    {
        return $deleterPermissionService->delete($id)->make();
    }
}