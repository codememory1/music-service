<?php

namespace App\Service;

use App\Enum\PlatformSettingEnum;
use App\Enum\PlatformSettingValueKeyEnum;
use App\Repository\PlatformSettingRepository;
use function is_array;

class PlatformSettingService
{
    public PlatformSettingRepository $platformSettingRepository;
    private mixed $setting = null;

    public function __construct(PlatformSettingRepository $platformSettingRepository)
    {
        $this->platformSettingRepository = $platformSettingRepository;
    }

    public function get(PlatformSettingEnum $platformSettingEnum): mixed
    {
        return $this->platformSettingRepository->getSetting($platformSettingEnum)?->getValue();
    }

    public function saveToMemory(PlatformSettingEnum $platformSettingEnum): self
    {
        $this->setting = $this->get($platformSettingEnum);

        return $this;
    }

    public function getFromValue(PlatformSettingValueKeyEnum $key): mixed
    {
        if (false === is_array($this->setting)) {
            return null;
        }

        return $this->setting[$key->value] ?? null;
    }

    public function getFirst(): mixed
    {
        if (is_array($this->setting)) {
            $firstKey = array_key_first($this->setting);

            return $this->setting[$firstKey];
        }

        return null;
    }
}