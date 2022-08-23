<?php

namespace App\ResponseData\Traits;

use App\Rest\Http\Request;
use App\Service\TranslationService;

trait ToTranslationHandlerTrait
{
    public function handleToTranslation(?string $translationKey): ?string
    {
        $translationService = $this->container->getService(TranslationService::class);
        $requestService = $this->container->getService(Request::class);

        $translationService->setLocale($requestService->getRequest()->getLocale());

        return $translationService->get($translationKey);
    }
}