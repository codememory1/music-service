<?php

namespace App\DataFixtures\Factory;

use App\DataFixtures\Interfaces\DataFixtureFactoryInterface;
use App\Entity\Interfaces\EntityInterface;
use App\Entity\PlatformSetting;
use App\Enum\PlatformSettingEnum;
use Doctrine\Common\DataFixtures\ReferenceRepository;

final class PlatformSettingFactory implements DataFixtureFactoryInterface
{
    private PlatformSettingEnum $platformSetting;
    private array|string|int|float $value;

    public function __construct(PlatformSettingEnum $platformSetting, array|string|int|float $value = [])
    {
        $this->platformSetting = $platformSetting;
        $this->value = $value;
    }

    public function factoryMethod(): EntityInterface
    {
        $platformSetting = new PlatformSetting();

        $platformSetting->setKey($this->platformSetting);
        $platformSetting->setValue($this->value);

        return $platformSetting;
    }

    public function setReferenceRepository(ReferenceRepository $referenceRepository): DataFixtureFactoryInterface
    {
        return $this;
    }
}