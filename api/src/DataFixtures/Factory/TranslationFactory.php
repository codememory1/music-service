<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class TranslationFactory implements DataFixtureFactoryInterface
{
    private ?ReferenceRepository $referenceRepository = null;

    public function __construct(
        private readonly string $language,
        private readonly string $translationKey,
        private readonly string $translation
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        /** @var Language $language */
        $language = $this->referenceRepository->getReference("l-{$this->language}");

        /** @var TranslationKey $translationKey */
        $translationKey = $this->referenceRepository->getReference("tk-{$this->translationKey}");
        $translation = new Translation();

        $translation->setLanguage($language);
        $translation->setTranslationKey($translationKey);
        $translation->setTranslation($this->translation);

        return $translation;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        $this->referenceRepository = $referenceRepository;

        return $this;
    }
}