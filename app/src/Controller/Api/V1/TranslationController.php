<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\LanguageTranslationDto;
use App\Entity\Language;
use App\Repository\LanguageRepository;
use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class TranslationController extends AbstractApiController
{

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    #[Route('/translator/translations', methods: 'GET')]
    public function all(Request $request): JsonResponse
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->managerRegistry->getRepository(Language::class);
        $language = $languageRepository->findOneBy([
            'code' => $request->getLocale()
        ]);
        $translationDto = new LanguageTranslationDto($language->getTranslations()->getValues());

        $apiResponseSchema = new ApiResponseSchema('success', 200);

        $apiResponseSchema->setData($translationDto->transform());

        $apiResponseService = new ApiResponseService($apiResponseSchema);

        return $apiResponseService->make();

    }

}