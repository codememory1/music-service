<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\UserRolePermission;
use App\DTO\SubscriptionDTO;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Service\Subscription\CreateSubscriptionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/subscription')]
class SubscriptionController extends AbstractRestController
{
    /**
     * @param SubscriptionDTO           $subscriptionDTO
     * @param CreateSubscriptionService $createSubscriptionService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_SUBSCRIPTION)]
    public function create(SubscriptionDTO $subscriptionDTO, CreateSubscriptionService $createSubscriptionService): JsonResponse
    {
        return $createSubscriptionService->make($subscriptionDTO->collect());
    }
}