<?php

namespace App\Service;

use App\Repository\LanguageRepository;
use App\Repository\TranslationKeyRepository;
use App\Repository\TranslationRepository;
use App\Rest\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class TranslationService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class TranslationService extends AbstractService
{
    #[Required]
    public ?LanguageRepository $languageRepository = null;

    #[Required]
    public ?TranslationKeyRepository $translationKeyRepository = null;

    #[Required]
    public ?TranslationRepository $translationRepository = null;

    #[Required]
    public ?Request $request = null;

    /**
     * @param string $key
     *
     * @return null|string
     */
    public function get(string $key): ?string
    {
        return $this->translationRepository->findOneBy([
            'language' => $this->languageRepository->findOneBy(['code' => $this->request->request->getLocale()]),
            'translationKey' => $this->translationKeyRepository->findOneBy(['key' => $key])
        ])?->getTranslation();
    }
}