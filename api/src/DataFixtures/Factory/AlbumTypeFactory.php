<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\AlbumType;
use App\Entity\Interfaces\EntityInterface;
use App\Enum\AlbumTypeEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class AlbumTypeFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
final class AlbumTypeFactory implements DataFixtureFactoryInterface
{
    /**
     * @var AlbumTypeEnum
     */
    private AlbumTypeEnum $key;

    /**
     * @var string
     */
    private string $titleTranslationKey;

    /**
     * @param AlbumTypeEnum $albumTypeEnum
     * @param string        $titleTranslationKey
     */
    public function __construct(AlbumTypeEnum $albumTypeEnum, string $titleTranslationKey)
    {
        $this->key = $albumTypeEnum;
        $this->titleTranslationKey = $titleTranslationKey;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        $albumTypeEntity = new AlbumType();

        $albumTypeEntity->setKey($this->key);
        $albumTypeEntity->setTitle($this->titleTranslationKey);

        return $albumTypeEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}