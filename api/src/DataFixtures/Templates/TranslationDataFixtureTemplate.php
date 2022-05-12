<?php

namespace App\DataFixtures\Templates;

use App\DataFixtures\Interfaces\DataFixtureTemplateInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class TranslationDataFixtureTemplate
 *
 * @package App\DataFixtures\Templates
 *
 * @author  Codememory
 */
final class TranslationDataFixtureTemplate implements DataFixtureTemplateInterface
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
     * @var ReferenceRepository|null
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
    public function getEntity(): EntityInterface
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
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureTemplateInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}