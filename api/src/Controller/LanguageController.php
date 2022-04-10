<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\LanguageDTO;
use App\Entity\Language;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\Translator\Language\CreatorLanguageService;
use App\Service\Translator\Language\DeleterLanguageService;
use App\Service\Translator\Language\UpdaterLanguageService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LanguageController.
 *
 * @package App\Controller
 *
 * @author  Codememory
 */
#[Route('/language')]
class LanguageController extends ApiController
{
    /**
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    public function all(): JsonResponse
    {
        return $this->showAllFromDatabase(Language::class, LanguageDTO::class);
    }

    /**
     * @param CreatorLanguageService $creatorLanguageService
     * @param LanguageDTO            $languageDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_LANG)]
    public function create(CreatorLanguageService $creatorLanguageService, LanguageDTO $languageDTO): JsonResponse
    {
        return $creatorLanguageService->create($languageDTO)->make();
    }

    /**
     * @param UpdaterLanguageService $updaterLanguageService
     * @param LanguageDTO            $languageDTO
     * @param int                    $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_LANG)]
    public function update(UpdaterLanguageService $updaterLanguageService, LanguageDTO $languageDTO, int $id): JsonResponse
    {
        return $updaterLanguageService->update($languageDTO, $id)->make();
    }

    /**
     * @param DeleterLanguageService $deleterLanguageService
     * @param int                    $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_LANG)]
    public function delete(DeleterLanguageService $deleterLanguageService, int $id): JsonResponse
    {
        return $deleterLanguageService->delete($id)->make();
    }
}