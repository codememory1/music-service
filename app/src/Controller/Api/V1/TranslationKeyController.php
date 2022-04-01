<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\TranslationKeyDTO;
use App\Entity\TranslationKey;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Translator\TranslationKey\CreatorTranslationKeyService;
use App\Service\Translator\TranslationKey\DeleterTranslationKeyService;
use App\Service\Translator\TranslationKey\UpdaterTranslationKeyService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationKeyController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
#[Route('/translation/key')]
class TranslationKeyController extends ApiController
{

	/**
	 * @return JsonResponse
	 */
	#[Route('/all', methods: 'GET')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::SHOW_TRANSLATION_KEYS)]
	public function all(): JsonResponse
	{

		return $this->showAllFromDatabase(TranslationKey::class, TranslationKeyDTO::class);

	}

	/**
	 * @param CreatorTranslationKeyService $creatorTranslationKeyService
	 * @param Request                      $request
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/create', methods: 'POST')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::CREATE_TRANSLATION_KEY)]
	public function create(CreatorTranslationKeyService $creatorTranslationKeyService, Request $request): JsonResponse
	{

		return $creatorTranslationKeyService
			->create(new TranslationKeyDTO($request, $this->managerRegistry))
			->make();

	}

	/**
	 * @param UpdaterTranslationKeyService $updaterTranslationKeyService
	 * @param Request                      $request
	 * @param int                          $id
	 *
	 * @return JsonResponse
	 * @throws UndefinedClassForDTOException
	 */
	#[Route('/{id<\d+>}/edit', methods: 'PUT')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_TRANSLATION_KEY)]
	public function update(UpdaterTranslationKeyService $updaterTranslationKeyService, Request $request, int $id): JsonResponse
	{

		return $updaterTranslationKeyService
			->update(new TranslationKeyDTO($request, $this->managerRegistry), $id)
			->make();

	}

	/**
	 * @param DeleterTranslationKeyService $deleterTranslationKeyService
	 * @param int                          $id
	 *
	 * @return JsonResponse
	 * @throws Exception
	 */
	#[Route('/{id<\d+>}/delete', methods: 'DELETE')]
	#[Auth]
	#[UserRolePermission(permission: RolePermissionNameEnum::DELETE_TRANSLATION_KEY)]
	public function delete(DeleterTranslationKeyService $deleterTranslationKeyService, int $id): JsonResponse
	{

		return $deleterTranslationKeyService->delete($id)->make();

	}

}