<?php

namespace App\Controller;

use App\Annotation\Auth;
use App\Annotation\UserRolePermission;
use App\DTO\TranslationKeyDTO;
use App\Entity\TranslationKey;
use App\Enum\RolePermissionNameEnum;
use App\Rest\ApiController;
use App\Service\TranslationKey\CreatorTranslationKeyService;
use App\Service\TranslationKey\DeleterTranslationKeyService;
use App\Service\TranslationKey\UpdaterTranslationKeyService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationKeyController.
 *
 * @package App\Controller
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
        return $this->findAllResponse(TranslationKey::class, TranslationKeyDTO::class);
    }

    /**
     * @param CreatorTranslationKeyService $creatorTranslationKeyService
     * @param TranslationKeyDTO            $translationKeyDTO
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::CREATE_TRANSLATION_KEY)]
    public function create(CreatorTranslationKeyService $creatorTranslationKeyService, TranslationKeyDTO $translationKeyDTO): JsonResponse
    {
        return $creatorTranslationKeyService->create($translationKeyDTO)->make();
    }

    /**
     * @param UpdaterTranslationKeyService $updaterTranslationKeyService
     * @param TranslationKeyDTO            $translationKeyDTO
     * @param int                          $id
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/edit', methods: 'PUT')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::UPDATE_TRANSLATION_KEY)]
    public function update(UpdaterTranslationKeyService $updaterTranslationKeyService, TranslationKeyDTO $translationKeyDTO, int $id): JsonResponse
    {
        return $updaterTranslationKeyService->update($translationKeyDTO, $id)->make();
    }

    /**
     * @param DeleterTranslationKeyService $deleterTranslationKeyService
     * @param int                          $id
     *
     * @throws Exception
     *
     * @return JsonResponse
     */
    #[Route('/{id<\d+>}/delete', methods: 'DELETE')]
    #[Auth]
    #[UserRolePermission(permission: RolePermissionNameEnum::DELETE_TRANSLATION_KEY)]
    public function delete(DeleterTranslationKeyService $deleterTranslationKeyService, int $id): JsonResponse
    {
        return $deleterTranslationKeyService->delete($id)->make();
    }
}