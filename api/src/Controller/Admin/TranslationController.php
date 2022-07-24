<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\DeleteTranslationDTO;
use App\DTO\TranslationDTO;
use App\Entity\Translation;
use App\Enum\RolePermissionEnum;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Translation\CreateTranslationService;
use App\Service\Translation\DeleteTranslationService;
use App\Service\Translation\UpdateTranslationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/translation')]
class TranslationController extends AbstractRestController
{
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_TRANSLATION)]
    public function create(TranslationDTO $translationDTO, CreateTranslationService $createTranslationService): JsonResponse
    {
        return $createTranslationService->make($translationDTO->collect());
    }

    #[Route('/{translation_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_TRANSLATION)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'translation')] Translation $translation,
        TranslationDTO $translationDTO,
        UpdateTranslationService $updateTranslationService
    ): JsonResponse {
        $translationDTO->setEntity($translation);
        $translationDTO->collect();

        return $updateTranslationService->make($translationDTO);
    }

    #[Route('/{translation_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_TRANSLATION)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'translation')] Translation $translation,
        DeleteTranslationDTO $translationDTO,
        DeleteTranslationService $deleteTranslationService
    ): JsonResponse {
        return $deleteTranslationService->make($translationDTO->collect(), $translation);
    }
}