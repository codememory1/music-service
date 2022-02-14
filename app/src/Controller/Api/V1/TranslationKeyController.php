<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\TranslationKeyDTO;
use App\Entity\TranslationKey;
use App\Service\RequestDataService;
use App\Service\Translator\TranslationKey\CreatorTranslationKeyService;
use App\Service\Translator\TranslationKey\DeleterTranslationKeyService;
use App\Service\Translator\TranslationKey\UpdaterTranslationKeyService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TranslationKeyController
 *
 * @package App\Controller\Api\V1
 *
 * @author  Codememory
 */
class TranslationKeyController extends AbstractApiController
{

    /**
     * @return JsonResponse
     */
    #[Route('/translator/translation-keys', methods: 'GET')]
    public function all(): JsonResponse
    {

        return $this->showAllFromDatabase(TranslationKey::class, TranslationKeyDTO::class);

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation-key/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorTranslationKeyService $service */
        $service = $this->getCollectedService($request, CreatorTranslationKeyService::class);
        $translationKeyDTO = new TranslationKeyDTO($requestDataService, $this->managerRegistry);

        return $service->create($translationKeyDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation-key/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterTranslationKeyService $service */
        $service = $this->getCollectedService($request, UpdaterTranslationKeyService::class);
        $translationKeyDTO = new TranslationKeyDTO($requestDataService, $this->managerRegistry);

        return $service->update($translationKeyDTO, $this->validator, $id)->make();

    }

    /**
     * @param Request $request
     * @param int     $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation-key/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterTranslationKeyService $service */
        $service = $this->getCollectedService($request, DeleterTranslationKeyService::class);

        return $service->delete($this->validator, $id)->make();

    }

}