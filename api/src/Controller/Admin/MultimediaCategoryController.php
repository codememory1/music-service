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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/multimedia/category')]
#[Authorization]
class MultimediaCategoryController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    public function all(MultimediaCategoryResponseData $responseData, MultimediaCategoryRepository $multimediaCategoryRepository): JsonResponse
    {
        return $this->responseData($responseData, $multimediaCategoryRepository->findAll());
    }

    #[Route('/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_MULTIMEDIA_CATEGORY)]
    public function create(
        MultimediaCategoryTransformer $transformer,
        CreateMultimediaCategory $createMultimediaCategory,
        MultimediaCategoryResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $createMultimediaCategory->process($transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{multimediaCategory_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_CATEGORY)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        MultimediaCategoryTransformer $transformer,
        UpdateMultimediaCategory $updateMultimediaCategory,
        MultimediaCategoryResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateMultimediaCategory->process($transformer->transformFromRequest($multimediaCategory)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{multimediaCategory_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_CATEGORY)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimediaCategory')] MultimediaCategory $multimediaCategory,
        DeleteMultimediaCategory $deleteMultimediaCategory,
        MultimediaCategoryResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $deleteMultimediaCategory->process($multimediaCategory),
            PlatformCodeEnum::DELETED
        );
    }
}