<?php

namespace App\Service;

use App\Enum\PlatformSettingEnum;
use App\Repository\PlatformSettingRepository;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Class PlatformSettingService.
 *
 * @package App\Service
 *
 * @author  Codememory
 */
class PlatformSettingService
{
    #[Required]
    public ?PlatformSettingRepository $platformSettingRepository = null;

    /**
     * @param PlatformSettingEnum $platformSettingEnum
     *
     * @return mixed
     */
    public function get(PlatformSettingEnum $platformSettingEnum): mixed
    {
        return $this->platformSettingRepository->getSetting($platformSettingEnum->name)?->getValue();
    }
}