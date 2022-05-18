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
    /**
     * @var string
     */
    private string $code;

    /**
     * @var string
     */
    private string $originalTitle;

    /**
     * @param string $code
     * @param string $originalTitle
     */
    public function __construct(string $code, string $originalTitle)
    {
        $this->code = $code;
        $this->originalTitle = $originalTitle;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        $languageEntity = new Language();

        $languageEntity->setCode($this->code);
        $languageEntity->setOriginalTitle($this->originalTitle);

        return $languageEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}