<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\LanguageCode;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class LanguageCodeFactory implements DataFixtureFactoryInterface
{
    private string $twoLetterCode;
    private string $threeLetterCode;
    private string $title;

    public function __construct(string $twoLetterCode, string $threeLetterCode, string $title)
    {
        $this->twoLetterCode = $twoLetterCode;
        $this->threeLetterCode = $threeLetterCode;
        $this->title = $title;
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