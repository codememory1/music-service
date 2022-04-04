<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\Subscription\CreatorSubscriptionService;
use App\Service\Subscription\DeleterSubscriptionService;
use App\Service\Subscription\UpdaterSubscriptionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/subscription')]
class SubscriptionController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    public function all(): JsonResponse
    {
        return $this->showAllFromDatabase(Subscription::class, SubscriptionDTO::class);
    }

    /**
     * @param CreatorSubscriptionService $creatorSubscriptionService
     * @param SubscriptionDTO            $subscriptionDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_SUBSCRIPTION)]
    public function create(CreatorSubscriptionService $creatorSubscriptionService, SubscriptionDTO $subscriptionDTO): JsonResponse
    {
        return $creatorSubscriptionService->create($subscriptionDTO)->make();
    }

    /**
     * @param UpdaterSubscriptionService $updaterSubscriptionService
     * @param SubscriptionDTO            $subscriptionDTO
     * @param int                        $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_SUBSCRIPTION)]
    public function update(UpdaterSubscriptionService $updaterSubscriptionService, SubscriptionDTO $subscriptionDTO, int $id): JsonResponse
    {
        return $updaterSubscriptionService->update($subscriptionDTO, $id)->make();
    }

    /**
     * @param DeleterSubscriptionService $deleterSubscriptionService
     * @param int                        $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_SUBSCRIPTION)]
    public function delete(DeleterSubscriptionService $deleterSubscriptionService, int $id): JsonResponse
    {
        return $deleterSubscriptionService->delete($id)->make();
    }
}