<?php

namespace App\Controller\Api\V1;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\Controller\Api\ApiController;
use App\DTO\LanguageDTO;
use App\Entity\Language;
use App\Enum\RolePermissionNameEnum;
use App\Exception\UndefinedClassForDTOException;
use App\Rest\Http\Request;
use App\Service\Translator\Language\CreatorLanguageService;
use App\Service\Translator\Language\DeleterLanguageService;
use App\Service\Translator\Language\UpdaterLanguageService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LanguageController.
 *
 * @package App\Controller\Api\V1
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
     * @param Request                $request
     *
     * @throws UndefinedClassForDTOException
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_LANG)]
    public function create(CreatorLanguageService $creatorLanguageService, Request $request): JsonResponse
    {
        return $creatorLanguageService
            ->create(new LanguageDTO($request, $this->managerRegistry))
            ->make();
    }

    /**
     * @param UpdaterLanguageService $updaterLanguageService
     * @param Request                $request
     * @param int                    $id
     *
     * @throws UndefinedClassForDTOException
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_LANG)]
    public function update(UpdaterLanguageService $updaterLanguageService, Request $request, int $id): JsonResponse
    {
        return $updaterLanguageService
            ->update(new LanguageDTO($request, $this->managerRegistry), $id)
            ->make();
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