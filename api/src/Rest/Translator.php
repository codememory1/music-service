<?php

namespace App\Rest;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use App\Repository\LanguageRepository;
use App\Repository\TranslationKeyRepository;
use App\Repository\TranslationRepository;
use App\Rest\Http\Request;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class Translator.
 *
 * @package App\Rest
 *
 * @author  Codememory
 */
class Translator
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @param EntityManagerInterface $em
     * @param Request                $request
     */
    public function __construct(EntityManagerInterface $em, Request $request)
    {
        $this->em = $em;
        $this->request = $request;
    }

    /**
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    public function getTranslation(string $key, string $default = ''): string
    {
        /** @var TranslationRepository $translationRepository */
        $translationRepository = $this->em->getRepository(Translation::class);

        /** @var TranslationKeyRepository $translationKeyRepository */
        $translationKeyRepository = $this->em->getRepository(TranslationKey::class);

        return $translationRepository->findOneBy([
            'lang' => $this->getActiveLang(),
            'translationKey' => $translationKeyRepository->findOneBy(['name' => $key])
        ])?->getTranslation() ?? $default;
    }

    /**
     * @return null|Language
     */
    public function getActiveLang(): ?Language
    {
        /** @var LanguageRepository $languageRepository */
        $languageRepository = $this->em->getRepository(Language::class);
        $activeLangCode = $this->request->request->getLocale();

        return $languageRepository->findOneBy(['code' => $activeLangCode]);
    }
}