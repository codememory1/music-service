<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class TranslationKeyFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class TranslationKeyFactory implements DataFixtureFactoryInterface
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
    public function factoryMethod(): EntityInterface
    {
        $translationKeyEntity = new TranslationKey();

        $translationKeyEntity->setKey($this->key);

        return $translationKeyEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}