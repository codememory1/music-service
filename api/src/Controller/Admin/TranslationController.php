<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\DeleteTranslationTransformer;
use App\Dto\Transformer\TranslationTransformer;
use App\Entity\Translation;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Rest\Controller\AbstractRestController;
use App\Service\Translation\CreateTranslation;
use App\Service\Translation\DeleteTranslation;
use App\Service\Translation\UpdateTranslation;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/translation')]
#[Authorization]
class TranslationController extends AbstractRestController
{
    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_TRANSLATION)]
    public function create(TranslationTransformer $translationTransformer, CreateTranslation $createTranslationService): JsonResponse
    {
        return $createTranslationService->request($translationTransformer->transformFromRequest());
    }

    #[Route('/{translation_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_TRANSLATION)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'translation')] Translation $translation,
        TranslationTransformer $translationTransformer,
        UpdateTranslation $updateTranslationService
    ): JsonResponse {
        return $updateTranslationService->request($translationTransformer->transformFromRequest($translation));
    }

    #[Route('/{translation_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_TRANSLATION)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'translation')] Translation $translation,
        DeleteTranslationTransformer $deleteTranslationTransformer,
        DeleteTranslation $deleteTranslationService
    ): JsonResponse {
        return $deleteTranslationService->request($deleteTranslationTransformer->transformFromRequest(), $translation);
    }
}