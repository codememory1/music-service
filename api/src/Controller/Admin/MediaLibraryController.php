<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MediaLibraryTransformer;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\MediaLibrary\MediaLibraryMultimediaResponseData;
use App\Rest\Controller\AbstractRestController;
use App\UseCase\MediaLibrary\CreateMediaLibrary;
use App\UseCase\MediaLibrary\UpdateMediaLibrary;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
#[Authorization]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/media-library/multimedia/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::SHOW_MEDIA_LIBRARY_TO_USER)]
    public function allMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        if (null === $user->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $responseData->setEntities($user->getMediaLibrary()->getMultimedia());

        return $this->responseData($responseData);
    }

    #[Route('/{user_id<\d+>}/media-library/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MediaLibraryTransformer $transformer,
        CreateMediaLibrary $createMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($createMediaLibrary->process(
            $transformer->transformFromRequest(),
            $user
        ));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/media-library/{mediaLibrary_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibrary')] MediaLibrary $mediaLibrary,
        MediaLibraryTransformer $transformer,
        UpdateMediaLibrary $updateMediaLibrary,
        MediaLibraryMultimediaResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateMediaLibrary->process(
            $transformer->transformFromRequest($mediaLibrary)
        ));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }
}