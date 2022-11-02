<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\AlbumType;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\AlbumTypeEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class AlbumTypeFactory implements DataFixtureFactoryInterface
{
    public function __construct(
        private readonly AlbumTypeEnum $albumType, 
        private readonly string $titleTranslationKey
    ) {}

    public function factoryMethod(): EntityInterface
    {
        $albumType = new AlbumType();

        $albumType->setKey($this->albumType);
        $albumType->setTitle($this->titleTranslationKey);

        return $albumType;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}