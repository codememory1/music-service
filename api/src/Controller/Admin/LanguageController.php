<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\Dto\Transformer\LanguageTransformer;
use App\Entity\Language;
use App\Enum\RolePermissionEnum;
use App\Exception\Http\EntityNotFoundException;
use App\Repository\LanguageRepository;
use App\ResponseData\LanguageResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Service\Language\CreateLanguageService;
use App\Service\Language\DeleteLanguageService;
use App\Service\Language\UpdateLanguageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language')]
#[Authorization]
class LanguageController extends AbstractRestController
{
    #[Route('/all', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function all(LanguageResponseData $languageResponseData, LanguageRepository $languageRepository): JsonResponse
    {
        $languageResponseData->setEntities($languageRepository->findAll());

        return $this->responseData($languageResponseData);
    }

    #[Route('/{language_code<[a-z]+>}/read', methods: 'GET')]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageResponseData $languageResponseData
    ): JsonResponse {
        $languageResponseData->setEntities($language);

        return $this->responseData($languageResponseData);
    }

    #[Route('/create', methods: 'POST')]
    #[UserRolePermission(RolePermissionEnum::CREATE_LANGUAGE)]
    public function create(LanguageTransformer $languageTransformer, CreateLanguageService $createLanguageService): JsonResponse
    {
        return $createLanguageService->request($languageTransformer->transformFromRequest());
    }

    #[Route('/{language_id<\d+>}/edit', methods: 'PUT')]
    #[UserRolePermission(RolePermissionEnum::UPDATE_LANGUAGE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageTransformer $languageTransformer,
        UpdateLanguageService $updateLanguageService
    ): JsonResponse {
        return $updateLanguageService->request($languageTransformer->transformFromRequest($language));
    }

    #[Route('/{language_id<\d+>}/delete', methods: 'DELETE')]
    #[UserRolePermission(RolePermissionEnum::DELETE_LANGUAGE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        DeleteLanguageService $deleteLanguageService
    ): JsonResponse {
        return $deleteLanguageService->request($language);
    }
}