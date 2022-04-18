<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\SubscriptionPermissionNameDTO;
use App\Entity\SubscriptionPermissionName;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\SubscriptionPermissionName\CreatorPermissionNameService;
use App\Service\SubscriptionPermissionName\DeleterPermissionNameService;
use App\Service\SubscriptionPermissionName\UpdaterPermissionNameService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionPermissionNameController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/subscription/permission/name')]
class SubscriptionPermissionNameController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::SHOW_SUBSCRIPTION_PERMISSION_NAMES)]
    public function all(): JsonResponse
    {
        return $this->findAllResponse(SubscriptionPermissionName::class, SubscriptionPermissionNameDTO::class);
    }

    /**
     * @param CreatorPermissionNameService  $creatorPermissionNameService
     * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_SUBSCRIPTION_PERMISSION_NAME)]
    public function create(CreatorPermissionNameService $creatorPermissionNameService, SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO): JsonResponse
    {
        return $creatorPermissionNameService->create($subscriptionPermissionNameDTO)->make();
    }

    /**
     * @param UpdaterPermissionNameService  $updaterPermissionNameService
     * @param SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO
     * @param int                           $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_SUBSCRIPTION_PERMISSION_NAME)]
    public function update(UpdaterPermissionNameService $updaterPermissionNameService, SubscriptionPermissionNameDTO $subscriptionPermissionNameDTO, int $id): JsonResponse
    {
        return $updaterPermissionNameService->update($subscriptionPermissionNameDTO, $id)->make();
    }

    /**
     * @param DeleterPermissionNameService $deleterPermissionNameService
     * @param int                          $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_SUBSCRIPTION_PERMISSION_NAME)]
    public function delete(DeleterPermissionNameService $deleterPermissionNameService, int $id): JsonResponse
    {
        return $deleterPermissionNameService->delete($id)->make();
    }
}