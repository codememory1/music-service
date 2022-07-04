<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\MediaLibraryDTO;
use App\DTO\MultimediaMediaLibraryDTO;
use App\Entity\MediaLibrary;
use App\Entity\MultimediaMediaLibrary;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\ResponseData\MultimediaMediaLibraryResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\CreateMediaLibraryService;
use App\Service\MediaLibrary\DeleteMultimediaMediaLibraryService;
use App\Service\MediaLibrary\UpdateMediaLibraryService;
use App\Service\MediaLibrary\UpdateMultimediaMediaLibraryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaLibraryController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class MediaLibraryController extends AbstractRestController
{
    #[Route('/{user_id<\d+>}/media-library/multimedia/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::SHOW_MEDIA_LIBRARY_TO_USER)]
    public function allMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MultimediaMediaLibraryResponseData $multimediaMediaLibraryResponseData
    ): JsonResponse {
        $mediaLibrary = $user->getMediaLibrary();

        if (null === $mediaLibrary) {
            throw EntityNotFoundException::mediaLibraryNotCreated();
        }

        $multimediaMediaLibraryResponseData->setEntities($mediaLibrary->getMultimedia()->toArray());
        $multimediaMediaLibraryResponseData->collect();

        return $this->responseCollection->dataOutput($multimediaMediaLibraryResponseData->getResponse());
    }

    #[Route('/{user_id<\d+>}/media-library/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_MEDIA_LIBRARY_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        MediaLibraryDTO $mediaLibraryDTO,
        CreateMediaLibraryService $createMediaLibraryService
    ): JsonResponse {
        return $createMediaLibraryService->make($mediaLibraryDTO->collect(), $user);
    }

    #[Route('/media-library/{mediaLibrary_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'mediaLibrary')] MediaLibrary $mediaLibrary,
        MediaLibraryDTO $mediaLibraryDTO,
        UpdateMediaLibraryService $updateMediaLibraryService
    ): JsonResponse {
        $mediaLibraryDTO->setEntity($mediaLibrary);

        return $updateMediaLibraryService->make($mediaLibraryDTO->collect());
    }

    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function updateMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryDTO $multimediaMediaLibraryDTO,
        UpdateMultimediaMediaLibraryService $updateMultimediaMediaLibraryService
    ): JsonResponse {
        $multimediaMediaLibraryDTO->setEntity($multimediaMediaLibrary);

        return $updateMultimediaMediaLibraryService->make($multimediaMediaLibraryDTO->collect());
    }

    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function deleteMultimedia(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibraryService $deleteMultimediaMediaLibraryService
    ): JsonResponse {
        return $deleteMultimediaMediaLibraryService->make($multimediaMediaLibrary);
    }
}