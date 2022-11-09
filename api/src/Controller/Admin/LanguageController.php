<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\LanguageTransformer;
use App\Entity\Language;
use App\Enum\PlatformCodeEnum;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\LanguageRepository;
use App\ResponseData\General\Language\LanguageResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Language\CreateLanguage;
use App\Service\Language\DeleteLanguage;
use App\Service\Language\UpdateLanguage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language')]
#[Authorization]
class LanguageController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function all(LanguageResponseData $responseData, LanguageRepository $languageRepository): JsonResponse
    {
        $responseData->setEntities($languageRepository->findAll());

        return $this->responseData($responseData);
    }

    #[Route('/{language_code<[a-z]+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($language);

        return $this->responseData($responseData);
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_LANGUAGE)]
    public function create(LanguageTransformer $transformer, CreateLanguage $createLanguage, LanguageResponseData $responseData): JsonResponse
    {
        $responseData->setEntities($createLanguage->create($transformer->transformFromRequest()));

        return $this->responseData($responseData, PlatformCodeEnum::CREATED);
    }

    #[Route('/{language_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_LANGUAGE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageTransformer $transformer,
        UpdateLanguage $updateLanguage,
        LanguageResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($updateLanguage->update($transformer->transformFromRequest($language)));

        return $this->responseData($responseData, PlatformCodeEnum::UPDATED);
    }

    #[Route('/{language_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_LANGUAGE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        DeleteLanguage $deleteLanguage,
        LanguageResponseData $responseData
    ): JsonResponse {
        $responseData->setEntities($deleteLanguage->delete($language));

        return $this->responseData($responseData, PlatformCodeEnum::DELETED);
    }
}