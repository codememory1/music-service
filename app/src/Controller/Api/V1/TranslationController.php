<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\LanguageTranslationDto;
use App\Entity\Language;
use App\Entity\Translation;
use App\Repository\LanguageRepository;
use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use App\Service\Translator\Translation\AddTranslationService;
use App\Service\Translator\Translation\DeleterTranslationService;
use App\Service\Translator\Translation\UpdaterTranslationService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation/add', methods: 'POST')]
    public function add(Request $request, ValidatorInterface $validator): JsonResponse
    {

        $addTranslationService = new AddTranslationService($request, $this->response, $this->managerRegistry);
        $handler = function (Translation $translationEntity) use ($addTranslationService) {
            return $addTranslationService->push($translationEntity, 'translation@successAdd');
        };

        return $addTranslationService->add($validator, $handler)->make();

    }

    /**
     * @param int                $id
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation/{id<\d+>}/edit/', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        $updaterTranslationService = new UpdaterTranslationService($request, $this->response, $this->managerRegistry);
        $handler = function (Translation $translationEntity) use ($updaterTranslationService) {
            return $updaterTranslationService->push(
                $translationEntity,
                'translation@successUpdate',
                true
            );
        };

        return $updaterTranslationService->update($id, $validator, $handler)->make();

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation/{id<\d+>}/delete/', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        $deleterTranslationService = new DeleterTranslationService($request, $this->response, $this->managerRegistry);
        $handler = function (Translation $translationEntity) use ($deleterTranslationService) {
            return $deleterTranslationService->remove($translationEntity, 'translation@successDelete');
        };

        return $deleterTranslationService->delete($id, $handler)->make();

    }

}