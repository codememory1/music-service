<?php

namespace App\Service\Language;

use App\Dto\Transfer\LanguageDto;
use App\Entity\Language;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateLanguageService extends AbstractService
{
    public function create(LanguageDto $languageDto): Language
    {
        $this->validateWithEntity($languageDto);

        $language = $languageDto->getEntity();

        $this->flusherService->save($language);

        return $language;
    }

    public function request(LanguageDto $languageDto): JsonResponse
    {
        $this->create($languageDto);

        return $this->responseCollection->successCreate('language@successCreate');
    }
}