<?php

namespace App\Service\Translation;

use App\Dto\Transfer\DeleteTranslationDto;
use App\Entity\Translation;
use App\Rest\Response\HttpResponseCollection;
use App\Service\FlusherService;
use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteTranslationService
{
    public function __construct(
        private readonly FlusherService $flusherService,
        private readonly HttpResponseCollection $responseCollection
    ) {}

    public function delete(DeleteTranslationDto $deleteTranslationDto, Translation $translation): Translation
    {
        $this->flusherService->addRemove($translation);

        if ($deleteTranslationDto->deleteKey) {
            $this->flusherService->addRemove($translation->getTranslationKey());
        }

        $this->flusherService->save();

        return $translation;
    }

    public function request(DeleteTranslationDto $deleteTranslationDto, Translation $translation): JsonResponse
    {
        $this->delete($deleteTranslationDto, $translation);

        return $this->responseCollection->successDelete('translation@successDelete');
    }
}