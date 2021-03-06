<?php

namespace App\Controller\Admin;

use App\Annotation\Authorization;
use App\Annotation\EntityNotFound;
use App\Annotation\UserRolePermission;
use App\DTO\LanguageDTO;
use App\Entity\Language;
use App\Enum\RolePermissionEnum;
use App\Repository\LanguageRepository;
use App\ResponseData\LanguageResponseData;
use App\Rest\Controller\AbstractRestController;
use App\Rest\Http\Exceptions\EntityNotFoundException;
use App\Service\Language\CreateLanguageService;
use App\Service\Language\DeleteLanguageService;
use App\Service\Language\UpdateLanguageService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LanguageController.
 *
 * @package App\Controller\Admin
 *
 * @author  Codememory
 */
#[Route('/language')]
class LanguageController extends AbstractRestController
{
    /**
     * @param LanguageResponseData $languageResponseData
     * @param LanguageRepository   $languageRepository
     *
     * @return JsonResponse
     */
    #[Route('/all', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function all(LanguageResponseData $languageResponseData, LanguageRepository $languageRepository): JsonResponse
    {
        $languageResponseData->setEntities($languageRepository->findAll());
        $languageResponseData->collect();

        return $this->responseCollection->dataOutput($languageResponseData->getResponse());
    }

    /**
     * @param Language             $language
     * @param LanguageResponseData $languageResponseData
     *
     * @return JsonResponse
     */
    #[Route('/{language_code<[a-z]+>}/read', methods: 'GET')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::VIEW_LANGUAGES_WITH_FULL_INFO)]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageResponseData $languageResponseData
    ): JsonResponse {
        $languageResponseData->setEntities($language);

        return $this->responseCollection->dataOutput($languageResponseData->collect()->getResponse(true));
    }

    /**
     * @param LanguageDTO           $languageDTO
     * @param CreateLanguageService $createLanguageService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::CREATE_LANGUAGE)]
    public function create(LanguageDTO $languageDTO, CreateLanguageService $createLanguageService): JsonResponse
    {
        return $createLanguageService->make($languageDTO->collect());
    }

    /**
     * @param Language              $language
     * @param LanguageDTO           $languageDTO
     * @param UpdateLanguageService $updateLanguageService
     *
     * @return JsonResponse
     */
    #[Route('/{language_id<\d+>}/edit', methods: 'PUT')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::UPDATE_LANGUAGE)]
    public function update(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageDTO $languageDTO,
        UpdateLanguageService $updateLanguageService
    ): JsonResponse {
        $languageDTO->setEntity($language)->collect();

        return $updateLanguageService->make($languageDTO);
    }

    /**
     * @param Language              $language
     * @param DeleteLanguageService $deleteLanguageService
     *
     * @return JsonResponse
     */
    #[Route('/{language_id<\d+>}/delete', methods: 'DELETE')]
    #[Authorization]
    #[UserRolePermission(RolePermissionEnum::DELETE_LANGUAGE)]
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        DeleteLanguageService $deleteLanguageService
    ): JsonResponse {
        return $deleteLanguageService->make($language);
    }
}