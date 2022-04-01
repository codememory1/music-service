<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\SubscriptionPermission;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\AlbumDTO;
use App\Entity\Album;
use App\Enum\RolePermissionNameEnum;
use App\Enum\SubscriptionPermissionNameEnum;
use App\Rest\Http\Request;
use App\Security\TokenAuthenticator;
use App\Service\Album\CreatorAlbumService;
use App\Service\Album\DeleterAlbumService;
use App\Service\Album\UpdaterAlbumService;
use App\Service\FileUploaderService;
use Exception;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Jenssegers\Agent\Agent;

/**
 * Class AlbumController
 *
 * @package App\Controller\Api\V1
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
	 * @param Request             $request
	 * @param FileUploaderService $fileUploaderService
	 *
	 * @return JsonResponse
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	#[Route('/create', methods: 'POST')]
	#[Auth]
	#[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::CREATE_ALBUM)]
	public function create(CreatorAlbumService $creatorAlbumService, Request $request, FileUploaderService $fileUploaderService): JsonResponse
	{

		$fileUploaderService
			->initRequestFile('photo')
			->setSaveTo('public/uploads/album');

		$albumDTO = new AlbumDTO($request, $this->managerRegistry);
		$user = (new TokenAuthenticator($request, $this->managerRegistry))->getUser();

		return $creatorAlbumService->create($albumDTO, $fileUploaderService, $user)->make();

	}

	/**
	 * @param UpdaterAlbumService $updaterAlbumService
	 * @param Request             $request
	 * @param FileUploaderService $fileUploaderService
	 * @param int                 $id
	 *
	 * @return JsonResponse
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 */
	#[Route('/{id<\d+>}/edit', methods: 'POST')]
	#[Auth]
	#[SubscriptionPermission(permission: SubscriptionPermissionNameEnum::UPDATE_ALBUM)]
	public function update(UpdaterAlbumService $updaterAlbumService, Request $request, FileUploaderService $fileUploaderService, int $id): JsonResponse
	{

		$fileUploaderService
			->initRequestFile('photo')
			->setSaveTo('public/uploads/album');

		$albumDTO = new AlbumDTO($request, $this->managerRegistry);
		$user = (new TokenAuthenticator($request, $this->managerRegistry))->getUser();

		return $updaterAlbumService->update(
			$albumDTO,
			$fileUploaderService,
			$user,
			$this->getParameter('kernel.project_dir'),
			$id
		)->make();

	}

	/**
	 * @param DeleterAlbumService $deleterAlbumService
	 * @param int                 $id
	 *
	 * @return JsonResponse
	 * @throws Exception
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