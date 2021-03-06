<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\SubscriptionDTO;
use App\Entity\Subscription;
use App\Enum\RolePermissionEnum;
use App\Repository\SubscriptionRepository;
use App\ResponseData\SubscriptionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Subscription\CreateSubscriptionService;
use App\Service\Subscription\DeleteSubscriptionService;
use App\Service\Subscription\UpdateSubscriptionService;
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
     * @param SubscriptionResponseData $subscriptionResponseData
     * @param SubscriptionRepository   $subscriptionRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public function all(SubscriptionResponseData $subscriptionResponseData, SubscriptionRepository $subscriptionRepository): JsonResponse
    {
        $subscriptionResponseData->setEntities($subscriptionRepository->findAll());
        $subscriptionResponseData->collect();

        return $this->responseCollection->dataOutput($subscriptionResponseData->getResponse());
    }

    /**
     * @param Subscription             $subscription
     * @param SubscriptionResponseData $subscriptionResponseData
     *
     * @return JsonResponse
     */
    #[Route('/{subscription_id<\d+>}/read', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        SubscriptionResponseData $subscriptionResponseData
    ): JsonResponse {
        $subscriptionResponseData->setEntities($subscription);
        $subscriptionResponseData->collect();

        return $this->responseCollection->dataOutput($subscriptionResponseData->getResponse(true));
    }

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
     * @param SubscriptionDTO           $subscriptionDTO
     * @param UpdateSubscriptionService $updateSubscriptionService
     *
     * @return JsonResponse
     */
    #[Route('/{subscription_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_SUBSCRIPTION)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        SubscriptionDTO $subscriptionDTO,
        UpdateSubscriptionService $updateSubscriptionService
    ): JsonResponse {
        $subscriptionDTO->setEntity($subscription);

        return $updateSubscriptionService->make($subscriptionDTO->collect(), $subscription);
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