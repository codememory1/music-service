<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class TranslationFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class TranslationFactory implements DataFixtureFactoryInterface
{
    /**
     * @var string
     */
    private string $language;

    /**
     * @var string
     */
    private string $translationKey;

    /**
     * @var string
     */
    private string $translation;

    /**
     * @var null|ReferenceRepository
     */
    private ?ReferenceRepository $referenceRepository = null;

    /**
     * @param string $language
     * @param string $translationKey
     * @param string $translation
     */
    public function __construct(string $language, string $translationKey, string $translation)
    {
        $this->language = $language;
        $this->translationKey = $translationKey;
        $this->translation = $translation;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        /** @var Language $language */
        $language = $this->referenceRepository->getReference("l-{$this->language}");

        /** @var TranslationKey $translationKey */
        $translationKey = $this->referenceRepository->getReference("tk-{$this->translationKey}");
        $translationEntity = new Translation();

        $translationEntity->setLanguage($language);
        $translationEntity->setTranslationKey($translationKey);
        $translationEntity->setTranslation($this->translation);

        return $translationEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}