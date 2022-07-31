<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\MultimediaMediaLibraryTransformer;
use App\Entity\MultimediaMediaLibrary;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\MediaLibrary\DeleteMultimediaMediaLibraryService;
use App\Service\MultimediaMediaLibrary\UpdateMultimediaMediaLibraryService;
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
#[Authorization]
class MultimediaMediaLibraryController extends AbstractRestController
{
    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/edit', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        MultimediaMediaLibraryTransformer $multimediaMediaLibraryTransformer,
        UpdateMultimediaMediaLibraryService $updateMultimediaMediaLibraryService
    ): JsonResponse {
        return $updateMultimediaMediaLibraryService->request(
            $multimediaMediaLibraryTransformer->transformFromRequest($multimediaMediaLibrary)
        );
    }

    #[Route('/media-library/multimedia/{multimediaMediaLibrary_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_MULTIMEDIA_MEDIA_LIBRARY_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'multimedia')] MultimediaMediaLibrary $multimediaMediaLibrary,
        DeleteMultimediaMediaLibraryService $deleteMultimediaMediaLibraryService
    ): JsonResponse {
        return $deleteMultimediaMediaLibraryService->request($multimediaMediaLibrary);
    }
}