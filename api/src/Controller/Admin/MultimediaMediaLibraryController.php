<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaMediaLibraryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\MediaLibrary\Multimedia\DeleteMultimediaMediaLibrary;
use App\UseCase\MediaLibrary\Multimedia\UpdateMultimediaMediaLibrary;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryTransformer $transformer,
        UpdateMultimediaMediaLibrary $updateMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateMultimediaMediaLibrary->process(
            $transformer->transformFromRequest($multimediaMediaLibrary)
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibrary $deleteMultimediaMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteMultimediaMediaLibrary->process($multimediaMediaLibrary));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}