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
        $translation = $this->getTranslation($key);

        $this->replaceParameters($translation, $parameters);

        return $translation;
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
     * @param string $key
     *
     * @return null|string
     */
    public function getTranslation(string $key): ?string
    {
        return $this->translationRepository->findOneBy([
            'language' => $this->getLanguage(),
            'translationKey' => $this->getTranslationKey($key)
        ])?->getTranslation();
    }

    /**
     * @param null|string $translation
     * @param array       $parameters
     *
     * @return void
     */
    private function replaceParameters(?string &$translation, array $parameters): void
    {
        if (null !== $translation) {
            foreach ($parameters as $name => $value) {
                if (str_starts_with($name, '@')) {
                    $name = mb_substr($name, 1);
                    $value = $this->getTranslation($value);
                }

                $parameterName = $this->convertParametersToTemplate($name);

                $translation = str_replace($parameterName, $value, $translation);
            }
        }
    }

    /**
     * @param string $parameter
     *
     * @return string
     */
    private function convertParametersToTemplate(string $parameter): string
    {
        return "%${parameter}%";
    }
}