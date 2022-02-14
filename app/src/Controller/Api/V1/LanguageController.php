<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\DTO\LanguageDTO;
use App\Entity\Language;
use App\Exception\UndefinedClassForDTOException;
use App\Service\RequestDataService;
use App\Service\Translator\Language\CreatorLanguageService;
use App\Service\Translator\Language\DeleterLanguageService;
use App\Service\Translator\Language\UpdaterLanguageService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        return $this->showAllFromDatabase(Language::class, LanguageDTO::class);

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     *
     * @return JsonResponse
     * @throws UndefinedClassForDTOException
     */
    #[Route('/translator/language/create', methods: 'POST')]
    public function create(Request $request, RequestDataService $requestDataService): JsonResponse
    {

        /** @var CreatorLanguageService $service */
        $service = $this->getCollectedService($request, CreatorLanguageService::class);
        $languageDTO = new LanguageDTO($requestDataService, $this->managerRegistry);

        return $service->create($languageDTO, $this->validator)->make();

    }

    /**
     * @param Request            $request
     * @param RequestDataService $requestDataService
     * @param int                $id
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/language/{id<\d+>}/edit', methods: 'PUT')]
    public function update(Request $request, RequestDataService $requestDataService, int $id): JsonResponse
    {

        /** @var UpdaterLanguageService $service */
        $service = $this->getCollectedService($request, UpdaterLanguageService::class);
        $languageDTO = new LanguageDTO($requestDataService, $this->managerRegistry);

        return $service->update($languageDTO, $this->validator, $id)->make();

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/language/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(Request $request, int $id): JsonResponse
    {

        /** @var DeleterLanguageService $service */
        $service = $this->getCollectedService($request, DeleterLanguageService::class);

        return $service->delete($this->validator, $id)->make();

    }

}