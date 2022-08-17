<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\AlbumType;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\AlbumTypeEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class AlbumTypeFactory implements DataFixtureFactoryInterface
{
    private AlbumTypeEnum $albumType;
    private string $titleTranslationKey;

    public function __construct(AlbumTypeEnum $albumType, string $titleTranslationKey)
    {
        $this->albumType = $albumType;
        $this->titleTranslationKey = $titleTranslationKey;
    }

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