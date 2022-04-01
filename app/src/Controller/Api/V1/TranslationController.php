<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\TranslationDTO;
use App\Entity\Translation;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Translator\Translation\CreatorTranslationService;
use App\Service\Translator\Translation\DeleterTranslationService;
use App\Service\Translator\Translation\UpdaterTranslationService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
#[Route('/translation')]
class TranslationController extends ApiController
{

	/**
	 * @return JsonResponse
	 */
	#[Route('/all', methods: 'GET')]
	public function all(): JsonResponse
	{

		return $this->showAllFromDatabase(Translation::class, TranslationDTO::class);

	}

	/**
	 * @param CreatorTranslationService $creatorTranslationService
	 * @param Request                   $request
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/create', methods: 'POST')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::CREATE_TRANSLATION)]
	public function create(CreatorTranslationService $creatorTranslationService, Request $request): JsonResponse
	{

		return $creatorTranslationService
			->create(new TranslationDTO($request, $this->managerRegistry))
			->make();

	}

	/**
	 * @param UpdaterTranslationService $updaterTranslationService
	 * @param Request                   $request
	 * @param int                       $id
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/{id<\d+>}/edit', methods: 'PUT')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_TRANSLATION)]
	public function update(UpdaterTranslationService $updaterTranslationService, Request $request, int $id): JsonResponse
	{

		return $updaterTranslationService
			->update(new TranslationDTO($request, $this->managerRegistry), $id)
			->make();

	}

	/**
	 * @param DeleterTranslationService $deleterTranslationService
	 * @param int                       $id
	 *
	 * @return JsonResponse
	 * @throws Exception
	 */
	#[Route('/{id<\d+>}/delete', methods: 'DELETE')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::DELETE_TRANSLATION)]
	public function delete(DeleterTranslationService $deleterTranslationService, int $id): JsonResponse
	{

		return $deleterTranslationService->delete($id)->make();

	}

}