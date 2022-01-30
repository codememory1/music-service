<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\LanguageDto;
use App\Entity\Language;
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

        return $this->showAllFromDatabase(Language::class, LanguageDto::class);

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
        $handler = function (Language $languageEntity) use ($creatorLanguageService) {
            return $creatorLanguageService->push($languageEntity, 'lang@successCreate');
        };

        return $creatorLanguageService->create($validator, $handler)->make();

    }

    /**
     * @param int                $id
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/language/{id<\d+>}/edit/', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        $updaterLanguageService = new UpdaterLanguageService($request, $this->response, $this->managerRegistry);
        $handler = function (Language $languageEntity) use ($updaterLanguageService) {
            return $updaterLanguageService->push(
                $languageEntity,
                'lang@successUpdate',
                true
            );
        };

        return $updaterLanguageService->update($id, $validator, $handler)->make();

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/language/{id<\d+>}/delete/', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        $deleterLanguageService = new DeleterLanguageService($request, $this->response, $this->managerRegistry);
        $handler = function (Language $languageEntity) use ($deleterLanguageService) {
            return $deleterLanguageService->remove($languageEntity, 'lang@successDelete');
        };

        return $deleterLanguageService->delete($id, $handler)->make();

    }

}