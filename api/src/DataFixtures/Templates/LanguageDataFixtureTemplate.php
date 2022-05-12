<?php

namespace App\DataFixtures\Templates;

use App\DataFixtures\Interfaces\DataFixtureTemplateInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\Language;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class LanguageDataFixtureTemplate
 *
 * @package App\DataFixtures\Templates
 *
 * @author  Codememory
 */
final class LanguageDataFixtureTemplate implements DataFixtureTemplateInterface
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
    public function getEntity(): EntityInterface
    {
        $languageEntity = new Language();

        $languageEntity->setCode($this->code);
        $languageEntity->setOriginalTitle($this->originalTitle);

        return $languageEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureTemplateInterface
    {
        return $this;   
    }
}