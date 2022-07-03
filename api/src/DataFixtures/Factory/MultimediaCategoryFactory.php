<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\MultimediaCategory;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class MultimediaCategoryFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class MultimediaCategoryFactory implements DataFixtureFactoryInterface
{
    private string $titleTranslationKey;

    public function __construct(string $titleTranslationKey)
    {
        $this->titleTranslationKey = $titleTranslationKey;
    }

    public function factoryMethod(): EntityInterface
    {
        $multimediaCategoryEntity = new MultimediaCategory();

        $multimediaCategoryEntity->setTitle($this->titleTranslationKey);

        return $multimediaCategoryEntity;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}