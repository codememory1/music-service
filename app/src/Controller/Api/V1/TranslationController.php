<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\TranslationDTO;
use App\Entity\Translation;
use App\Exception\UndefinedClassForDTOException;
use App\Service\RequestDataService;
use App\Service\Translator\Translation\CreatorTranslationService;
use App\Service\Translator\Translation\DeleterTranslationService;
use App\Service\Translator\Translation\UpdaterTranslationService;
use Exception;
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
     * @return JsonResponse
     */
    #[Route('/translator/translations', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(Translation::class, TranslationDTO::class);

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/translator/translation/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorTranslationService $service */
        $service = $this->getCollectedService($request, CreatorTranslationService::class);
        $translationDTO = new TranslationDTO($requestDataService, $this->managerRegistry);

        return $service->create($translationDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterTranslationService $service */
        $service = $this->getCollectedService($request, UpdaterTranslationService::class);
        $translationDTO = new TranslationDTO($requestDataService, $this->managerRegistry);

        return $service->update($translationDTO, $this->validator, $id)->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterTranslationService $service */
        $service = $this->getCollectedService($request, DeleterTranslationService::class);

        return $service->delete($id)->make();

    }

}