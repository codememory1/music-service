<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\SubscriptionTransformer;
use App\Entity\Subscription;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\SubscriptionRepository;
use App\ResponseData\General\Subscription\SubscriptionResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Subscription\CreateSubscription;
use App\UseCase\Subscription\DeleteSubscription;
use App\UseCase\Subscription\UpdateSubscription;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/subscription')]
#[Authorization]
class SubscriptionController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public function all(SubscriptionResponseData $responseData, SubscriptionRepository $subscriptionRepository): JsonResponse
    {
        return $this->responseData($responseData, $subscriptionRepository->findAll());
    }

    #[Route('/{subscription_id<\d+>}/read', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_FULL_INFO_SUBSCRIPTIONS)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        SubscriptionResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $subscription);
    }

    #[Route('/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_SUBSCRIPTION)]
    public function create(SubscriptionTransformer $transformer, CreateSubscription $createSubscription, SubscriptionResponseData $responseData): JsonResponse
    {
        return $this->responseData(
            $responseData,
            $createSubscription->process($transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{subscription_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_SUBSCRIPTION)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        SubscriptionTransformer $transformer,
        UpdateSubscription $updateSubscription,
        SubscriptionResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateSubscription->process($transformer->transformFromRequest($subscription)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{subscription_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_SUBSCRIPTION)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'subscription')] Subscription $subscription,
        DeleteSubscription $deleteSubscription,
        SubscriptionResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $deleteSubscription->process($subscription), PlatformCodeEnum::DELETED);
    }
}