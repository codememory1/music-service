<?php

namespace App\Service;

use App\Entity\Language;
use App\Entity\TranslationKey;
use App\Repository\LanguageRepository;
use App\Repository\TranslationKeyRepository;
use App\Repository\TranslationRepository;
use Symfony\Contracts\Service\Attribute\Required;

class TranslationService
{
    #[Required]
    public ?LanguageRepository $languageRepository = null;

    #[Required]
    public ?TranslationKeyRepository $translationKeyRepository = null;

    #[Required]
    public ?TranslationRepository $translationRepository = null;
    private ?string $locale = null;

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

    public function get(string $key, array $parameters = []): ?string
    {
        $translation = $this->getTranslation($key);

        $this->replaceParameters($translation, $parameters);

        return $translation;
    }

    public function all(): array
    {
        if (null === $language = $this->getLanguage()) {
            return [];
        }
        
        return $this->translationRepository->findAllByLanguage($language);
    }

    public function getLanguage(): ?Language
    {
        return $this->languageRepository->findByLang($this->locale);
    }

    public function getTranslationKey(string $key): ?TranslationKey
    {
        return $this->translationKeyRepository->findByKey($key);
    }

    public function getTranslation(string $key): ?string
    {
        $language = $this->getLanguage();
        $translationKey = $this->getTranslationKey($key);
        
        if (null === $language || null === $translationKey) {
            return null;
        }
        
        return $this->translationRepository->findTranslation($language, $translationKey)->getTranslation();
    }

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

    private function convertParametersToTemplate(string $parameter): string
    {
        return "%${parameter}%";
    }
}