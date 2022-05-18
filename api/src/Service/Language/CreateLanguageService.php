<?php

namespace App\Service\Language;

use App\DTO\LanguageDTO;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class CreateLanguageService
 *
 * @package App\Service\Language
 *
 * @author  Codememory
 */
class CreateLanguageService extends AbstractService
{
    /**
     * @param LanguageDTO $languageDTO
     *
     * @return JsonResponse
     */
    public function make(LanguageDTO $languageDTO): JsonResponse
    {
        $languageEntity = $languageDTO->getEntity();

        if (false === $this->validate($languageDTO)) {
            return $this->validator->getResponse();
        }

        if (false === $this->validate($languageEntity)) {
            return $this->validator->getResponse();
        }

        $this->em->persist($languageEntity);
        $this->em->flush();

        return $this->responseCollection->successCreate('language@successCreate');
    }
}