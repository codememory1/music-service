<?php

namespace App\ResponseData\Traits;

use App\Service\TranslationService;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Trait ToTranslationHandlerTrait.
 *
 * @package App\ResponseData\Traits
 *
 * @author  Codememory
 */
trait ToTranslationHandlerTrait
{
    #[Required]
    public ?TranslationService $translationService = null;

    /**
     * @param null|string $translationKey
     *
     * @return null|string
     */
    public function handleToTranslation(?string $translationKey): ?string
    {
        return $this->translationService->get($translationKey);
    }
}