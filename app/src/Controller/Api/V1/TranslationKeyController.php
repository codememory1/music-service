<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\TranslationKeyDto;
use App\Entity\TranslationKey;
use App\Service\Translator\Translation\CreatorTranslationService;
use App\Service\Translator\TranslationKey\CreatorTranslationKeyService;
use App\Service\Translator\TranslationKey\DeleterTranslationKeyService;
use App\Service\Translator\TranslationKey\UpdaterTranslationKeyService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        return $this->showAllFromDatabase(TranslationKey::class, TranslationKeyDto::class);

    }

    /**
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation-key/create', methods: 'POST')]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeCreateService(
            CreatorTranslationKeyService::class,
            'translationKey@successCreate',
            $request,
            $validator
        );

    }

    /**
     * @param int                $id
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation-key/{id<\d+>}/edit', methods: 'PUT')]
    public function update(int $id, Request $request, ValidatorInterface $validator): JsonResponse
    {

        return $this->executeUpdateService(
            $id,
            UpdaterTranslationKeyService::class,
            'translationKey@successUpdate',
            $request,
            $validator
        );

    }

    /**
     * @param int     $id
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Exception
     */
    #[Route('/translator/translation-key/{id<\d+>}/delete', methods: 'DELETE')]
    public function delete(int $id, Request $request): JsonResponse
    {

        return $this->executeDeleteService(
            $id,
            DeleterTranslationKeyService::class,
            'translationKey@successDelete',
            $request
        );

    }

}