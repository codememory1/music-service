<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\MediaLibraryDTO;
use App\Entity\MediaLibrary;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\CreateMediaLibraryService;
use App\Service\MediaLibrary\UpdateMediaLibraryService;
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
    /**
     * @param User                      $user
     * @param MediaLibraryDTO           $mediaLibraryDTO
     * @param CreateMediaLibraryService $createMediaLibraryService
     *
     * @return JsonResponse
     */
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

    /**
     * @param MediaLibrary              $mediaLibrary
     * @param MediaLibraryDTO           $mediaLibraryDTO
     * @param UpdateMediaLibraryService $updateMediaLibraryService
     *
     * @return JsonResponse
     */
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
}