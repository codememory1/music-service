<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\DeleteTranslationTransformer;
use App\Dto\Transformer\TranslationTransformer;
use App\Entity\Translation;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\ResponseData\General\Translation\TranslationResponseData;
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
    public function create(TranslationTransformer $transformer, CreateTranslation $createTranslation, TranslationResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($createTranslation->create($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{translation_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_TRANSLATION)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'translation')] Translation $translation,
        TranslationTransformer $transformer,
        UpdateTranslation $updateTranslation,
        TranslationResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateTranslation->update($transformer->transformFromRequest($translation)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/{translation_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_TRANSLATION)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'translation')] Translation $translation,
        DeleteTranslationTransformer $transformer,
        DeleteTranslation $deleteTranslation,
        TranslationResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteTranslation->delete(
            $transformer->transformFromRequest(),
            $translation
        ));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}