<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\MultimediaCategoryDTO;
use App\Entity\MultimediaCategory;
use App\Enum\RolePermissionEnum;
use App\Repository\MultimediaCategoryRepository;
use App\ResponseData\MultimediaCategoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MultimediaCategory\CreateMultimediaCategoryService;
use App\Service\MultimediaCategory\DeleteMultimediaCategoryService;
use App\Service\MultimediaCategory\UpdateMultimediaCategoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaCategoryController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/multimedia/category')]
class MultimediaCategoryController extends AbstractRestController
{
    /**
     * @param MultimediaCategoryResponseData $multimediaCategoryResponseData
     * @param MultimediaCategoryRepository   $multimediaCategoryRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    public function all(MultimediaCategoryResponseData $multimediaCategoryResponseData, MultimediaCategoryRepository $multimediaCategoryRepository): JsonResponse
    {
        $multimediaCategoryResponseData->setEntities($multimediaCategoryRepository->findAll());
        $multimediaCategoryResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaCategoryResponseData->getResponse());
    }

    /**
     * @param MultimediaCategoryDTO           $multimediaCategoryDTO
     * @param CreateMultimediaCategoryService $createMultimediaCategoryService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_MULTIMEDIA_CATEGORY)]
    public function create(MultimediaCategoryDTO $multimediaCategoryDTO, CreateMultimediaCategoryService $createMultimediaCategoryService): JsonResponse
    {
        return $createMultimediaCategoryService->make($multimediaCategoryDTO->collect());
    }

    /**
     * @param MultimediaCategory              $multimediaCategory
     * @param MultimediaCategoryDTO           $multimediaCategoryDTO
     * @param UpdateMultimediaCategoryService $updateMultimediaCategoryService
     *
     * @return JsonResponse
     */
    #[Route('/{multimediaCategory_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_CATEGORY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        MultimediaCategoryDTO $multimediaCategoryDTO,
        UpdateMultimediaCategoryService $updateMultimediaCategoryService
    ): JsonResponse {
        $multimediaCategoryDTO->setEntity($multimediaCategory);

        return $updateMultimediaCategoryService->make($multimediaCategoryDTO->collect());
    }

    /**
     * @param MultimediaCategory              $multimediaCategory
     * @param DeleteMultimediaCategoryService $deleteMultimediaCategoryService
     *
     * @return JsonResponse
     */
    #[Route('/{multimediaCategory_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_CATEGORY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        DeleteMultimediaCategoryService $deleteMultimediaCategoryService
    ): JsonResponse {
        return $deleteMultimediaCategoryService->make($multimediaCategory);
    }
}