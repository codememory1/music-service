<?php

namespace App\Service\Language;

use App\DTO\LanguageDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateLanguageService.
 *
 * @package App\Service\Language
 *
 * @author  Codememory
 */
class CreateLanguageService extends AbstractService
{
    public function make(LanguageDTO $languageDTO): JsonResponse
    {
        if (true !== $response = $this->validateFullDTO($languageDTO)) {
            return $response;
        }

        $languageEntity = $languageDTO->getEntity();

        $this->em->persist($languageEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('language@successCreate');
    }
}