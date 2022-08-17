<?php

namespace App\Service;

use App\Enum\PlatformSettingEnum;
use App\Enum\PlatformSettingValueKeyEnum;
use App\Repository\PlatformSettingRepository;
use function is_array;
use Symfony\Contracts\Service\Attribute\Required;

class PlatformSettingService
{
    #[Required]
    public ?PlatformSettingRepository $platformSettingRepository = null;
    private mixed $setting = null;

    public function get(PlatformSettingEnum $platformSettingEnum): mixed
    {
        return $this->platformSettingRepository->getSetting($platformSettingEnum->name)?->getValue();
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
}