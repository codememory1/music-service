<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaCategory;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class MultimediaCategoryFactory implements DataFixtureFactoryInterface
{
    private string $titleTranslationKey;

    public function __construct(string $titleTranslationKey)
    {
        $this->titleTranslationKey = $titleTranslationKey;
    }

    public function factoryMethod(): EntityInterface
    {
        $multimediaCategory = new MultimediaCategory();

        $multimediaCategory->setTitle($this->titleTranslationKey);

        return $multimediaCategory;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}