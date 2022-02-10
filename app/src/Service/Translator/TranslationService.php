<?php

namespace App\Service\Translator;

use App\Entity\Language;
use App\Entity\Translation;
use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use JetBrains\PhpStorm\Pure;

/**
 * Class TranslationService
 *
 * @package  App\Service\Translator
 *
 * @author   Codememory
 */
class TranslationService
{

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @var string
     */
    private string $locale;

    /**
     * @param ManagerRegistry $managerRegistry
     * @param string          $locale
     */
    public function __construct(ManagerRegistry $managerRegistry, string $locale)
    {

        $this->managerRegistry = $managerRegistry;
        $this->locale = $locale;

    }

    /**
     * @return string
     */
    #[Pure]
    public function getActiveLang(): string
    {

        return $this->locale;

    }

    /**
     * @return Collection|null
     */
    public function activeLanguageTranslations(): ?Collection
    {

        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->managerRegistry->getRepository(Language::class);

        return $languageRepository->findOneBy([
            'code' => $this->getActiveLang()
        ])?->getTranslations();

    }

    /**
     * @param string $key
     *
     * @return Translation|null
     * @throws Exception
     */
    public function getActiveLanguageTranslation(string $key): ?Translation
    {

        $iteratorTranslations = $this->activeLanguageTranslations()?->getIterator();

        /** @var Translation $translation */
        foreach ($iteratorTranslations ?? [] as $translation) {
            if ($translation->getTranslationKey()->getName() === $key) {
                return $translation;
            }
        }

        return null;

    }

}