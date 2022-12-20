<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\LogicBranchTransformer;
use App\Dto\Transformer\MonetizationBranchTransformer;
use App\Dto\Transformer\SubscriptionPermissionBranchTransformer;
use App\Entity\LogicBranch;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\LogicBranchRepository;
use App\Repository\MonetizationBranchRepository;
use App\Repository\SubscriptionPermissionBranchRepository;
use App\ResponseData\Admin\Branch\BranchResponseData;
use App\ResponseData\Admin\Branch\LogicBranchResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Branch\UpdateLogicBranch;
use App\UseCase\Branch\UpdateMonetizationBranch;
use App\UseCase\Branch\UpdateSubscriptionPermissionBranch;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/branch')]
#[Authorization]
class BranchController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_ALL_BRANCHES)]
    public function allBranches(LogicBranchRepository $logicBranchRepository, LogicBranchResponseData $responseData): JsonResponse
    {
        return $this->responseData($responseData, $logicBranchRepository->findAll());
    }

    #[Route('/{logicBranch_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_BRANCH)]
    public function updateBranch(
        #[EntityNotFound(EntityNotFoundException::class, 'logicBranch')] LogicBranch $logicBranch,
        UpdateLogicBranch $updateLogicBranch,
        LogicBranchTransformer $transformer,
        LogicBranchResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateLogicBranch->process($transformer->transformFromRequest($logicBranch)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/subscription-permission/data/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_DATA_BRANCH)]
    public function allSubscriptionPermissionBranchData(
        SubscriptionPermissionBranchRepository $subscriptionPermissionBranchRepository,
        BranchResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $subscriptionPermissionBranchRepository->findAll());
    }

    #[Route('/subscription-permission/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_DATA_BRANCH)]
    public function updateSubscriptionPermissionBranch(
        SubscriptionPermissionBranchTransformer $transformer,
        UpdateSubscriptionPermissionBranch $updateSubscriptionPermissionBranch,
        SubscriptionPermissionBranchRepository $subscriptionPermissionBranchRepository,
        BranchResponseData $responseData
    ): JsonResponse {
        $updateSubscriptionPermissionBranch->process($transformer->transformFromRequest());

        return $this->responseData($responseData, $subscriptionPermissionBranchRepository->findAll(), PlatformCodeEnum::UPDATED);
    }

    #[Route('/monetization/data/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::SHOW_DATA_BRANCH)]
    public function allMonetizationBranchData(
        MonetizationBranchRepository $monetizationBranchRepository,
        BranchResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $monetizationBranchRepository->findAll());
    }

    #[Route('/monetization/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_DATA_BRANCH)]
    public function updateMonetizationBranch(
        MonetizationBranchTransformer $transformer,
        UpdateMonetizationBranch $updateMonetizationBranch,
        MonetizationBranchRepository $monetizationBranchRepository,
        BranchResponseData $responseData
    ): JsonResponse {
        $updateMonetizationBranch->process($transformer->transformFromRequest());

        return $this->responseData($responseData, $monetizationBranchRepository->findAll(), PlatformCodeEnum::UPDATED);
    }
}