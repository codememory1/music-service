<?php

namespace App\DataFixtures\Templates;

use App\DataFixtures\Interfaces\DataFixtureTemplateInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class TranslationKeyDataFixtureTemplate.
 *
 * @package App\DataFixtures\Templates
 *
 * @author  Codememory
 */
final class TranslationKeyDataFixtureTemplate implements DataFixtureTemplateInterface
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @inheritDoc
     */
    public function getEntity(): EntityInterface
    {
        $translationKeyEntity = new TranslationKey();

        $translationKeyEntity->setKey($this->key);

        return $translationKeyEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureTemplateInterface
    {
        return $this;
    }
}