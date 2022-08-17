<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class LanguageFactory implements DataFixtureFactoryInterface
{
    private string $code;
    private string $originalTitle;

    public function __construct(string $code, string $originalTitle)
    {
        $this->code = $code;
        $this->originalTitle = $originalTitle;
    }

    public function factoryMethod(): EntityInterface
    {
        $language = new Language();

        $language->setCode($this->code);
        $language->setOriginalTitle($this->originalTitle);

        return $language;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}