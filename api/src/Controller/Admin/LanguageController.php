<?php

namespace App\Controller\Admin;

use App\Annotation\EntityNotFound;
use App\DTO\LanguageDTO;
use App\Entity\Language;
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
    public function all(LanguageResponseData $languageResponseData, LanguageRepository $languageRepository): JsonResponse
    {
        $languageResponseData->setEntities($languageRepository->findAll());

        return $this->responseCollection->dataOutput($languageResponseData->collect()->getResponse());
    }

    /**
     * @param Language             $language
     * @param LanguageResponseData $languageResponseData
     *
     * @return JsonResponse
     */
    #[Route('/{language_code<[a-z]+>}/read', methods: 'GET')]
    public function read(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        LanguageResponseData $languageResponseData
    ): JsonResponse {
        $languageResponseData->setEntities($language);

        return $this->responseCollection->dataOutput($languageResponseData->collect()->getResponse());
    }

    /**
     * @param LanguageDTO           $languageDTO
     * @param CreateLanguageService $createLanguageService
     *
     * @return JsonResponse
     */
    #[Route('/create', methods: 'POST')]
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
    public function delete(
        #[EntityNotFound(EntityNotFoundException::class, 'language')] Language $language,
        DeleteLanguageService $deleteLanguageService
    ): JsonResponse {
        return $deleteLanguageService->make($language);
    }
}