<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MediaLibraryTransformer;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\MultimediaMediaLibraryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\MediaLibrary\CreateMediaLibraryService;
use App\Service\MediaLibrary\UpdateMediaLibraryService;
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
        MultimediaMediaLibraryResponseData $multimediaMediaLibraryResponseData
    ): JsonResponse {
        if (null === $user->getMediaLibrary()) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $multimediaMediaLibraryResponseData->setEntities($user->getMediaLibrary()->getMultimedia());

        return $this->responseData($multimediaMediaLibraryResponseData);
    }

    #[Route('/{user_id<\d+>}/media-library/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MediaLibraryTransformer $mediaLibraryTransformer,
        CreateMediaLibraryService $createMediaLibraryService
    ): JsonResponse {
        return $createMediaLibraryService->request($mediaLibraryTransformer->transformFromRequest(), $user);
    }

    #[Route('/media-library/{mediaLibrary_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibrary')] MediaLibrary $mediaLibrary,
        MediaLibraryTransformer $mediaLibraryTransformer,
        UpdateMediaLibraryService $updateMediaLibraryService
    ): JsonResponse {
        return $updateMediaLibraryService->request($mediaLibraryTransformer->transformFromRequest($mediaLibrary));
    }
}