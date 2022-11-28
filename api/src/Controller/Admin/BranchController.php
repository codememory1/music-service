<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\LogicBranchTransformer;
use App\Entity\LogicBranch;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\LogicBranchRepository;
use App\ResponseData\Admin\Branch\LogicBranchResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\LogicBranches\UpdateLogicBranch;
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
        $responseData->setEntities($logicBranchRepository->findAll());

        return $this->responseData($responseData);
    }

    #[Route('/{logicBranch_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_BRANCH)]
    public function updateBranch(
        #[EntityNotFound(EntityNotFoundException::class, 'logicBranch')] LogicBranch $logicBranch,
        UpdateLogicBranch $updateLogicBranch,
        LogicBranchTransformer $transformer,
        LogicBranchResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateLogicBranch->update($transformer->transformFromRequest($logicBranch)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}