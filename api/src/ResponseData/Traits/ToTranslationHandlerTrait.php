<?php

namespace App\ResponseData\Traits;

use App\Service\TranslationService;

/**
 * Trait ToTranslationHandlerTrait.
 *
 * @package App\ResponseData\Traits
 *
 * @author  Codememory
 */
trait ToTranslationHandlerTrait
{
    /**
     * @param null|string $translationKey
     *
     * @return null|string
     */
    public function handleToTranslation(?string $translationKey): ?string
    {
        $translationService = $this->container->getService(TranslationService::class);

        return $translationService->get($translationKey);
    }
}