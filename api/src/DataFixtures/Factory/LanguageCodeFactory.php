<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\LanguageCode;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class LanguageCodeFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly string $twoLetterCode,
        private readonly string $threeLetterCode,
        private readonly string $title
    ) {
    }

    public function factoryMethod(): EntityInterface
    {
        $languageCode = new LanguageCode();

        $languageCode->setTwoLetterCode($this->twoLetterCode);
        $languageCode->setThreeLetterCode($this->threeLetterCode);
        $languageCode->setTitle($this->title);

        return $languageCode;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}