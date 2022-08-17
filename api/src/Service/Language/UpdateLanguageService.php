<?php

namespace App\Service\Language;

use App\Dto\Transfer\LanguageDto;
use App\Entity\Language;
use App\Service\AbstractService;
use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateLanguageService extends AbstractService
{
    public function update(LanguageDto $languageDto): Language
    {
        $this->validateWithEntity($languageDto);

        $this->flusherService->save();

        return $languageDto->getEntity();
    }

    public function request(LanguageDto $languageDto): JsonResponse
    {
        $this->update($languageDto);

        return $this->responseCollection->successUpdate('language@successUpdate');
    }
}