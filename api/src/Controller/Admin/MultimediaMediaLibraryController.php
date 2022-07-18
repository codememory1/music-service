<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\MultimediaMediaLibraryDTO;
use App\Entity\MultimediaMediaLibrary;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\DeleteMultimediaMediaLibraryService;
use App\Service\MediaLibrary\UpdateMultimediaMediaLibraryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MultimediaMediaLibraryController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/user')]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function update(
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
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibraryService $deleteMultimediaMediaLibraryService
    ): JsonResponse {
        return $deleteMultimediaMediaLibraryService->make($multimediaMediaLibrary);
    }
}