<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\AlbumTypeDTO;
use App\Entity\AlbumType;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Album\Type\CreatorAlbumTypeService;
use App\Service\Album\Type\DeleterAlbumTypeService;
use App\Service\Album\Type\UpdaterAlbumTypeService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AlbumTypeController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
#[Route('/album/type')]
class AlbumTypeController extends ApiController
{

	/**
	 * @return JsonResponse
	 */
	#[Route('/all', methods: 'GET')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::SHOW_ALBUM_TYPES)]
	public function all(): JsonResponse
	{

		return $this->showAllFromDatabase(
			AlbumType::class,
			AlbumTypeDTO::class
		);

	}

	/**
	 * @param CreatorAlbumTypeService $creatorAlbumTypeService
	 * @param Request                 $request
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/create', methods: 'POST')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::CREATE_ALBUM_TYPE)]
	public function create(CreatorAlbumTypeService $creatorAlbumTypeService, Request $request): JsonResponse
	{

		return $creatorAlbumTypeService
			->create(new AlbumTypeDTO($request, $this->managerRegistry))
			->make();

	}

	/**
	 * @param UpdaterAlbumTypeService $updaterAlbumTypeService
	 * @param Request                 $request
	 * @param int                     $id
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/{id<\d+>}/edit', methods: 'PUT')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_ALBUM_TYPE)]
	public function update(UpdaterAlbumTypeService $updaterAlbumTypeService, Request $request, int $id): JsonResponse
	{

		return $updaterAlbumTypeService
			->update(new AlbumTypeDTO($request, $this->managerRegistry), $id)
			->make();

	}

	/**
	 * @param DeleterAlbumTypeService $deleterAlbumTypeService
	 * @param int                     $id
	 *
	 * @return JsonResponse
	 * @throws Exception
	 */
	#[Route('/{id<\d+>}/delete', methods: 'DELETE')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::DELETE_ALBUM_TYPE)]
	public function delete(DeleterAlbumTypeService $deleterAlbumTypeService, int $id): JsonResponse
	{

		return $deleterAlbumTypeService->delete($id)->make();

	}

}