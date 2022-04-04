<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\SubscriptionPermissionDTO;
use App\Entity\SubscriptionPermission;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\Subscription\Permission\CreatorPermissionService;
use App\Service\Subscription\Permission\DeleterPermissionService;
use App\Service\Subscription\Permission\UpdaterPermissionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionPermissionController.
 *
 * @package App\Controller
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
     * @param CreatorPermissionService  $creatorPermissionService
     * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_SUBSCRIPTION_PERMISSION)]
    public function create(CreatorPermissionService $creatorPermissionService, SubscriptionPermissionDTO $subscriptionPermissionDTO): JsonResponse
    {
        return $creatorPermissionService->create($subscriptionPermissionDTO)->make();
    }

    /**
     * @param UpdaterPermissionService  $updaterPermissionService
     * @param SubscriptionPermissionDTO $subscriptionPermissionDTO
     * @param int                       $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_SUBSCRIPTION_PERMISSION)]
    public function update(UpdaterPermissionService $updaterPermissionService, SubscriptionPermissionDTO $subscriptionPermissionDTO, int $id): JsonResponse
    {
        return $updaterPermissionService->update($subscriptionPermissionDTO, $id)->make();
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