<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaCategoryTransformer;
use App\Entity\MultimediaCategory;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaCategoryRepository;
use App\ResponseData\MultimediaCategoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\MultimediaCategory\CreateMultimediaCategoryService;
use App\Service\MultimediaCategory\DeleteMultimediaCategoryService;
use App\Service\MultimediaCategory\UpdateMultimediaCategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/multimedia/category')]
#[Authorization]
class MultimediaCategoryController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(MultimediaCategoryResponseData $multimediaCategoryResponseData, MultimediaCategoryRepository $multimediaCategoryRepository): JsonResponse
    {
        $multimediaCategoryResponseData->setEntities($multimediaCategoryRepository->findAll());

        return $this->responseCollection->dataOutput($multimediaCategoryResponseData->getResponse());
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_MULTIMEDIA_CATEGORY)]
    public function create(MultimediaCategoryTransformer $multimediaCategoryTransformer, CreateMultimediaCategoryService $createMultimediaCategoryService): JsonResponse
    {
        return $createMultimediaCategoryService->request($multimediaCategoryTransformer->transformFromRequest());
    }

    #[Route('/{multimediaCategory_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_CATEGORY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        MultimediaCategoryTransformer $multimediaCategoryTransformer,
        UpdateMultimediaCategoryService $updateMultimediaCategoryService
    ): JsonResponse {
        return $updateMultimediaCategoryService->request($multimediaCategoryTransformer->transformFromRequest($multimediaCategory));
    }

    #[Route('/{multimediaCategory_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_CATEGORY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        DeleteMultimediaCategoryService $deleteMultimediaCategoryService
    ): JsonResponse {
        return $deleteMultimediaCategoryService->request($multimediaCategory);
    }
}