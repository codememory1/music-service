<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Entity\User;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Album\CreateAlbumService;
use App\Service\Album\DeleteAlbumService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
class AlbumController extends AbstractRestController
{
    /**
     * @param User               $user
     * @param AlbumDTO           $albumDTO
     * @param CreateAlbumService $createAlbumService
     *
     * @return JsonResponse
     */
    #[Route('/user/{user_id<\d+>}/album/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_ALBUM_TO_USER)]
    public function create(
        #[EntityNotFound(EntityNotFoundException::class, 'user')] User $user,
        AlbumDTO $albumDTO,
        CreateAlbumService $createAlbumService
    ): JsonResponse {
        return $createAlbumService->make($albumDTO->collect(), $user);
    }

    /**
     * @param Album              $album
     * @param DeleteAlbumService $deleteAlbumService
     *
     * @return JsonResponse
     */
    #[Route('/user/album/{album_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_ALBUM_TO_USER)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'album')] Album $album,
        DeleteAlbumService $deleteAlbumService
    ): JsonResponse {
        return $deleteAlbumService->make($album);
    }
}