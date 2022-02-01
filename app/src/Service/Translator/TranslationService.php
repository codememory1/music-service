<?php

namespace App\Service\Translator;

use App\Entity\Language;
use App\Entity\Translation;
use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;

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
     * @var Request
     */
    private Request $request;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    /**
     * @param Request         $request
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(Request $request, ManagerRegistry $managerRegistry)
    {

        $this->request = $request;
        $this->managerRegistry = $managerRegistry;

    }

    /**
     * @return string
     */
    #[Pure]
    public function getActiveLang(): string
    {

        return $this->request->getLocale();

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