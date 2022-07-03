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
    private string $language;
    private string $translationKey;
    private string $translation;
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(string $language, string $translationKey, string $translation)
    {
        $this->language = $language;
        $this->translationKey = $translationKey;
        $this->translation = $translation;
    }

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

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}