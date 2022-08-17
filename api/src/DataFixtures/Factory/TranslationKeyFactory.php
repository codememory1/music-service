<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\TranslationKey;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class TranslationKeyFactory implements DataFixtureFactoryInterface
{
    private string $key;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function factoryMethod(): EntityInterface
    {
        $translationKey = new TranslationKey();

        $translationKey->setKey($this->key);

        return $translationKey;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}