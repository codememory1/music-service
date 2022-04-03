<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Subscription\CreatorSubscriptionService;
use App\Service\Subscription\DeleterSubscriptionService;
use App\Service\Subscription\UpdaterSubscriptionService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionController.
 *
 * @package App\Controller\Api\V1
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
     * @param Request                    $request
     *
     * @throws UndefinedClassForDTOException
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_SUBSCRIPTION)]
    public function create(CreatorSubscriptionService $creatorSubscriptionService, Request $request): JsonResponse
    {
        return $creatorSubscriptionService
            ->create(new SubscriptionDTO($request, $this->managerRegistry))
            ->make();
    }

    /**
     * @param UpdaterSubscriptionService $updaterSubscriptionService
     * @param Request                    $request
     * @param int                        $id
     *
     * @throws UndefinedClassForDTOException
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_SUBSCRIPTION)]
    public function update(UpdaterSubscriptionService $updaterSubscriptionService, Request $request, int $id): JsonResponse
    {
        return $updaterSubscriptionService
            ->update(new SubscriptionDTO($request, $this->managerRegistry), $id)
            ->make();
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