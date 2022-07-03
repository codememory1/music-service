<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class LanguageFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
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
        $languageEntity = new Language();

        $languageEntity->setCode($this->code);
        $languageEntity->setOriginalTitle($this->originalTitle);

        return $languageEntity;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}