<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\LanguageDto;
use App\Entity\Language;
use App\Repository\LanguageRepository;
use App\Service\Response\ApiResponseSchema;
use App\Service\Response\ApiResponseService;
use App\Service\Translator\Language\CreatorLanguageService;
use App\Service\Translator\Language\DeleterLanguageService;
use App\Service\Translator\Language\UpdaterLanguageService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class LanguageController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class LanguageController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/translator/languages', methods: 'GET')]
    public function all(): JsonResponse
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->managerRegistry->getRepository(Language::class);
        $languageDto = new LanguageDto($languageRepository->findAll());
        $apiResponseSchema = new ApiResponseSchema('success', 200);

        $apiResponseSchema->setData($languageDto->transform());

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
    #[Route('/translator/language/create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        $creatorLanguageService = new CreatorLanguageService($request, $this->response, $this->managerRegistry);

        return $creatorLanguageService->create($validator)->make();

    }

    /**
     * @param int                $id
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/language/update/{id<\d+>}', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        $updaterLanguageService = new UpdaterLanguageService($request, $this->response, $this->managerRegistry);

        return $updaterLanguageService->update($id, $validator)->make();

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/language/delete/{id<\d+>}', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        $deleterLanguageService = new DeleterLanguageService($request, $this->response, $this->managerRegistry);

        return $deleterLanguageService->delete($id)->make();

    }

}