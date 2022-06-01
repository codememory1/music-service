<?php

namespace App\Service;

use App\Entity\Language;
use App\Entity\TranslationKey;
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
class TranslationService
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
     * @param array  $parameters
     *
     * @return null|string
     */
    public function get(string $key, array $parameters = []): ?string
    {
        $translation = $this->translationRepository->findOneBy([
            'language' => $this->getLanguage(),
            'translationKey' => $this->getTranslationKey($key)
        ])?->getTranslation();

        return null === $translation ? null : str_replace($this->parametersToFormat($parameters), $parameters, $translation);
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return $this->translationRepository->findBy([
            'language' => $this->getLanguage()
        ]);
    }

    /**
     * @return null|Language
     */
    public function getLanguage(): ?Language
    {
        return $this->languageRepository->findOneBy([
            'code' => $this->request->request->getLocale()
        ]);
    }

    /**
     * @param string $key
     *
     * @return null|TranslationKey
     */
    public function getTranslationKey(string $key): ?TranslationKey
    {
        return $this->translationKeyRepository->findOneBy([
            'key' => $key
        ]);
    }

    /**
     * @param array $parameters
     *
     * @return array
     */
    private function parametersToFormat(array $parameters): array
    {
        return array_map(static fn(string $value) => "%${value}%", array_keys($parameters));
    }
}