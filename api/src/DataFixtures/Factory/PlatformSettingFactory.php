<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PlatformSetting;
use App\Enum\PlatformSettingEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

/**
 * Class PlatformSettingFactory.
 *
 * @package App\DataFixtures\Factory
 *
 * @author  Codememory
 */
class PlatformSettingFactory implements DataFixtureFactoryInterface
{
    /**
     * @var string
     */
    private string $key;

    /**
     * @var array
     */
    private array $value;

    /**
     * @param string $key
     * @param array  $value
     */
    public function __construct(PlatformSettingEnum $key, array $value = [])
    {
        $this->key = $key->name;
        $this->value = $value;
    }

    /**
     * @inheritDoc
     */
    public function factoryMethod(): EntityInterface
    {
        $platformSettingEntity = new PlatformSetting();

        $platformSettingEntity->setKey($this->key);
        $platformSettingEntity->setValue($this->value);

        return $platformSettingEntity;
    }

    /**
     * @inheritDoc
     */
    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}