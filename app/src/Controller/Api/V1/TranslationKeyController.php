<?php

namespace App\Controller\Api\V1;

use App\Controller\Api\AbstractApiController;
use App\Dto\TranslationKeyDto;
use App\Entity\TranslationKey;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        return $this->showAllFromDatabase(TranslationKey::class, TranslationKeyDto::class);

    }

}