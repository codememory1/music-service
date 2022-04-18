<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\TranslationDTO;
use App\Entity\Translation;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\Translation\CreatorTranslationService;
use App\Service\Translation\DeleterTranslationService;
use App\Service\Translation\UpdaterTranslationService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationController.
 *
 * @package App\Controller
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
        return $this->findAllResponse(Translation::class, TranslationDTO::class);
    }

    /**
     * @param CreatorTranslationService $creatorTranslationService
     * @param TranslationDTO            $translationDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_TRANSLATION)]
    public function create(CreatorTranslationService $creatorTranslationService, TranslationDTO $translationDTO): JsonResponse
    {
        return $creatorTranslationService->create($translationDTO)->make();
    }

    /**
     * @param UpdaterTranslationService $updaterTranslationService
     * @param TranslationDTO            $translationDTO
     * @param int                       $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_TRANSLATION)]
    public function update(UpdaterTranslationService $updaterTranslationService, TranslationDTO $translationDTO, int $id): JsonResponse
    {
        return $updaterTranslationService->update($translationDTO, $id)->make();
    }

    /**
     * @param DeleterTranslationService $deleterTranslationService
     * @param int                       $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_TRANSLATION)]
    public function delete(DeleterTranslationService $deleterTranslationService, int $id): JsonResponse
    {
        return $deleterTranslationService->delete($id)->make();
    }
}