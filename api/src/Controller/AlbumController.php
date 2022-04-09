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
use App\Security\Auth\Authenticator;
use App\Service\Album\CreatorAlbumService;
use App\Service\Album\DeleterAlbumService;
use App\Service\Album\UpdaterAlbumService;
use App\Service\FileUploaderService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
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
        return $this->showAllFromDatabase(
            Album::class,
            AlbumDTO::class
        );
    }

    /**
     * @param CreatorAlbumService $creatorAlbumService
     * @param AlbumDTO            $albumDTO
     * @param Authenticator       $tokenAuthenticator
     * @param FileUploaderService $fileUploaderService
     *
     * @return JsonResponse
     *@throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::CREATE_ALBUM)]
    public function create(CreatorAlbumService $creatorAlbumService, AlbumDTO $albumDTO, Authenticator $tokenAuthenticator, FileUploaderService $fileUploaderService): JsonResponse
    {
        $fileUploaderService
            ->initRequestFile('photo')
            ->setSaveTo('public/uploads/album');

        return $creatorAlbumService->create($albumDTO, $fileUploaderService, $tokenAuthenticator->getUser())->make();
    }

    /**
     * @param UpdaterAlbumService $updaterAlbumService
     * @param AlbumDTO            $albumDTO
     * @param Authenticator       $tokenAuthenticator
     * @param FileUploaderService $fileUploaderService
     * @param int                 $id
     *
     * @return JsonResponse
     *@throws NotFoundExceptionInterface
     *
     * @throws ContainerExceptionInterface
     */
    #[Route('/{id<\d+>}/edit', methods: 'POST')]
    #[Auth]
    #[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::UPDATE_ALBUM)]
    public function update(UpdaterAlbumService $updaterAlbumService, AlbumDTO $albumDTO, Authenticator $tokenAuthenticator, FileUploaderService $fileUploaderService, int $id): JsonResponse
    {
        $fileUploaderService
            ->initRequestFile('photo')
            ->setSaveTo('public/uploads/album');

        return $updaterAlbumService->update(
            $albumDTO,
            $fileUploaderService,
            $tokenAuthenticator->getUser(),
            $this->getParameter('kernel.project_dir'),
            $id
        )->make();
    }

    /**
     * @param DeleterAlbumService $deleterAlbumService
     * @param int                 $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::DELETE_ALBUM)]
    public function delete(DeleterAlbumService $deleterAlbumService, int $id): JsonResponse
    {
        return $deleterAlbumService->delete(
            $this->getParameter('kernel.project_dir'),
            $id
        )->make();
    }
}