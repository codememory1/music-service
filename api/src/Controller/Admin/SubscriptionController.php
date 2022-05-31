<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Subscription\CreateSubscriptionService;
use App\Service\Subscription\DeleteSubscriptionService;
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

    /**
     * @param Subscription              $subscription
     * @param DeleteSubscriptionService $deleteSubscriptionService
     *
     * @return JsonResponse
     */
    #[Route('/{subscription_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_SUBSCRIPTION)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        DeleteSubscriptionService $deleteSubscriptionService
    ): JsonResponse {
        return $deleteSubscriptionService->make($subscription);
    }
}