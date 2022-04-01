<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\SubscriptionPermissionNameDTO;
use App\Entity\SubscriptionPermissionName;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Subscription\Permission\Name\CreatorPermissionNameService;
use App\Service\Subscription\Permission\Name\DeleterPermissionNameService;
use App\Service\Subscription\Permission\Name\UpdaterPermissionNameService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SubscriptionPermissionNameController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
#[Route('/subscription/permission/name')]
class SubscriptionPermissionNameController extends ApiController
{

	/**
	 * @return JsonResponse
	 */
	#[Route('/all', methods: 'GET')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::SHOW_SUBSCRIPTION_PERMISSION_NAMES)]
	public function all(): JsonResponse
	{

		return $this->showAllFromDatabase(
			SubscriptionPermissionName::class,
			SubscriptionPermissionNameDTO::class
		);

	}

	/**
	 * @param CreatorPermissionNameService $creatorPermissionNameService
	 * @param Request                      $request
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/create', methods: 'POST')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::CREATE_SUBSCRIPTION_PERMISSION_NAME)]
	public function create(CreatorPermissionNameService $creatorPermissionNameService, Request $request): JsonResponse
	{

		return $creatorPermissionNameService
			->create(new SubscriptionPermissionNameDTO($request, $this->managerRegistry))
			->make();

	}

	/**
	 * @param UpdaterPermissionNameService $updaterPermissionNameService
	 * @param Request                      $request
	 * @param int                          $id
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/{id<\d+>}/edit', methods: 'PUT')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_SUBSCRIPTION_PERMISSION_NAME)]
	public function update(UpdaterPermissionNameService $updaterPermissionNameService, Request $request, int $id): JsonResponse
	{

		return $updaterPermissionNameService
			->update(new SubscriptionPermissionNameDTO($request, $this->managerRegistry), $id)
			->make();

	}

	/**
	 * @param DeleterPermissionNameService $deleterPermissionNameService
	 * @param int                          $id
	 *
	 * @return JsonResponse
	 * @throws Exception
	 */
	#[Route('/{id<\d+>}/delete', methods: 'DELETE')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::DELETE_SUBSCRIPTION_PERMISSION_NAME)]
	public function delete(DeleterPermissionNameService $deleterPermissionNameService, int $id): JsonResponse
	{

		return $deleterPermissionNameService->delete($id)->make();

	}

}