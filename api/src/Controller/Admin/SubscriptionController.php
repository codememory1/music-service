<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\SubscriptionTransformer;
use App\Entity\Subscription;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\SubscriptionRepository;
use App\ResponseData\SubscriptionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Subscription\CreateSubscriptionService;
use App\Service\Subscription\DeleteSubscriptionService;
use App\Service\Subscription\UpdateSubscriptionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subscription')]
#[Authorization]
class SubscriptionController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public function all(SubscriptionResponseData $subscriptionResponseData, SubscriptionRepository $subscriptionRepository): JsonResponse
    {
        $subscriptionResponseData->setEntities($subscriptionRepository->findAll());

        return $this->responseCollection->dataOutput($subscriptionResponseData->getResponse());
    }

    #[Route('/{subscription_id<\d+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        SubscriptionResponseData $subscriptionResponseData
    ): JsonResponse {
        $subscriptionResponseData->setEntities($subscription);

        return $this->responseCollection->dataOutput($subscriptionResponseData->getResponse(true));
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_SUBSCRIPTION)]
    public function create(SubscriptionTransformer $subscriptionTransformer, CreateSubscriptionService $createSubscriptionService): JsonResponse
    {
        return $createSubscriptionService->request($subscriptionTransformer->transformFromRequest());
    }

    #[Route('/{subscription_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_SUBSCRIPTION)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        SubscriptionTransformer $subscriptionTransformer,
        UpdateSubscriptionService $updateSubscriptionService
    ): JsonResponse {
        return $updateSubscriptionService->request($subscriptionTransformer->transformFromRequest($subscription));
    }

    #[Route('/{subscription_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_SUBSCRIPTION)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        DeleteSubscriptionService $deleteSubscriptionService
    ): JsonResponse {
        return $deleteSubscriptionService->request($subscription);
    }
}