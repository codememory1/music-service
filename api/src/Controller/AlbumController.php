<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\SubscriptionPermission;
use App\Annotation\UserRolePermission;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Enum\RolePermissionNameEnum;
use App\Enum\SubscriptionPermissionNameEnum;
use App\Rest\ApiController;
use App\Rest\S3\Uploader\ImageUploader;
use App\Security\Authenticator\Authenticator;
use App\Security\Authenticator\DefineUserForTask;
use App\Service\Album\CreatorAlbumService;
use App\Service\Album\DeleterAlbumService;
use App\Service\Album\UpdaterAlbumService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/album')]
class AlbumController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::SHOW_ALBUMS)]
    public function all(): JsonResponse
    {
        return $this->findAllResponse(Album::class, AlbumDTO::class);
    }

    /**
     * @param CreatorAlbumService $creatorAlbumService
     * @param AlbumDTO            $albumDTO
     * @param Authenticator       $authenticator
     * @param DefineUserForTask   $defineUserForTask
     * @param ImageUploader       $imageUploader
     * @param null|int            $userid
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::CREATE_ALBUM)]
    public function create(
        CreatorAlbumService $creatorAlbumService,
        AlbumDTO $albumDTO,
        Authenticator $authenticator,
        ImageUploader $imageUploader
    ): JsonResponse {
        return $creatorAlbumService->create(
            $albumDTO,
            $imageUploader,
            $authenticator->getAuthorizedUser()
        )->make();
    }

    /**
     * @param UpdaterAlbumService $updaterAlbumService
     * @param AlbumDTO            $albumDTO
     * @param Authenticator       $authenticator
     * @param ImageUploader       $imageUploader
     * @param int                 $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'POST')]
    #[Auth]
    #[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::UPDATE_ALBUM)]
    public function update(
        UpdaterAlbumService $updaterAlbumService,
        AlbumDTO $albumDTO,
        ImageUploader $imageUploader,
        int $id
    ): JsonResponse {
        return $updaterAlbumService->update($albumDTO, $imageUploader, $id)->make();
    }

    /**
     * @param DeleterAlbumService $deleterAlbumService
     * @param ImageUploader       $imageUploader
     * @param int                 $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::DELETE_ALBUM)]
    public function delete(DeleterAlbumService $deleterAlbumService, ImageUploader $imageUploader, int $id): JsonResponse
    {
        return $deleterAlbumService->delete($imageUploader, $id)->make();
    }
}