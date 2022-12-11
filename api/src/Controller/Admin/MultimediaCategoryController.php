<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaCategoryTransformer;
use App\Entity\MultimediaCategory;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\MultimediaCategoryRepository;
use App\ResponseData\General\Multimedia\MultimediaCategoryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\Multimedia\Category\CreateMultimediaCategory;
use App\UseCase\Multimedia\Category\DeleteMultimediaCategory;
use App\UseCase\Multimedia\Category\UpdateMultimediaCategory;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/multimedia/category')]
#[Authorization]
class MultimediaCategoryController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    public function all(MultimediaCategoryResponseData $responseData, MultimediaCategoryRepository $multimediaCategoryRepository): JsonResponse
    {
        $responseData->setEntities($multimediaCategoryRepository->findAll());

        return $this->responseData($responseData);
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_MULTIMEDIA_CATEGORY)]
    public function create(
        MultimediaCategoryTransformer $transformer,
        CreateMultimediaCategory $createMultimediaCategory,
        MultimediaCategoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($createMultimediaCategory->process($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{multimediaCategory_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_CATEGORY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        MultimediaCategoryTransformer $transformer,
        UpdateMultimediaCategory $updateMultimediaCategory,
        MultimediaCategoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateMultimediaCategory->process(
            $transformer->transformFromRequest($multimediaCategory)
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/{multimediaCategory_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_CATEGORY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        DeleteMultimediaCategory $deleteMultimediaCategory,
        MultimediaCategoryResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteMultimediaCategory->process($multimediaCategory));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}