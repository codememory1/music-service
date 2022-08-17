<?php

namespace App\ResponseData\Traits;

use App\Service\TranslationService;

trait ToTranslationHandlerTrait
{
    public function handleToTranslation(?string $translationKey): ?string
    {
        $translationService = $this->container->getService(TranslationService::class);

        return $translationService->get($translationKey);
    }
}