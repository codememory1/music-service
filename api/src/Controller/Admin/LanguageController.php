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
use App\UseCase\Language\CreateLanguage;
use App\UseCase\Language\DeleteLanguage;
use App\UseCase\Language\UpdateLanguage;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/language')]
#[Authorization]
class LanguageController extends AbstractRestController
{
    #[Route('/all', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function all(LanguageResponseData $responseData, LanguageRepository $languageRepository): JsonResponse
    {
        return $this->responseData($responseData, $languageRepository->findAll());
    }

    #[Route('/{language_code<[a-z]+>}/read', methods: Request::METHOD_GET)]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $language);
    }

    #[Route('/create', methods: Request::METHOD_POST)]
    #[UserRolePermission(RolePermissionEnum::CREATE_LANGUAGE)]
    public function create(LanguageTransformer $transformer, CreateLanguage $createLanguage, LanguageResponseData $responseData): JsonResponse
    {
        return $this->responseData(
            $responseData,
            $createLanguage->process($transformer->transformFromRequest()),
            PlatformCodeEnum::CREATED
        );
    }

    #[Route('/{language_id<\d+>}/edit', methods: Request::METHOD_PUT)]
    #[UserRolePermission(RolePermissionEnum::UPDATE_LANGUAGE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageTransformer $transformer,
        UpdateLanguage $updateLanguage,
        LanguageResponseData $responseData
    ): JsonResponse {
        return $this->responseData(
            $responseData,
            $updateLanguage->process($transformer->transformFromRequest($language)),
            PlatformCodeEnum::UPDATED
        );
    }

    #[Route('/{language_id<\d+>}/delete', methods: Request::METHOD_DELETE)]
    #[UserRolePermission(RolePermissionEnum::DELETE_LANGUAGE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        DeleteLanguage $deleteLanguage,
        LanguageResponseData $responseData
    ): JsonResponse {
        return $this->responseData($responseData, $deleteLanguage->process($language), PlatformCodeEnum::DELETED);
    }
}