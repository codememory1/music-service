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
    /**
     * @var null|LanguageRepository
     */
    private ?LanguageRepository $languageRepository = null;

    /**
     * @var null|TranslationKeyRepository
     */
    private ?TranslationKeyRepository $translationKeyRepository = null;

    /**
     * @var null|TranslationRepository
     */
    private ?TranslationRepository $translationRepository = null;

    /**
     * @var null|Request
     */
    private ?Request $request = null;

    /**
     * @param LanguageRepository $languageRepository
     *
     * @return void
     */
    #[Required]
    public function setLanguageRepository(LanguageRepository $languageRepository): void
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param TranslationKeyRepository $translationKeyRepository
     *
     * @return void
     */
    #[Required]
    public function setTranslationKeyRepository(TranslationKeyRepository $translationKeyRepository): void
    {
        $this->translationKeyRepository = $translationKeyRepository;
    }

    /**
     * @param TranslationRepository $translationRepository
     *
     * @return void
     */
    #[Required]
    public function setTranslationRepository(TranslationRepository $translationRepository): void
    {
        $this->translationRepository = $translationRepository;
    }

    /**
     * @param Request $request
     *
     * @return void
     */
    #[Required]
    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

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