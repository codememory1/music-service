<?php

namespace App\Repository;

use App\Entity\PlatformSetting;
use App\Enum\PlatformSettingEnum;

/**
 * @template-extends AbstractRepository<PlatformSetting>
 */
final class PlatformSettingRepository extends AbstractRepository
{
    protected ?string $entity = PlatformSetting::class;
    protected ?string $alias = 'ps';

    public function getSetting(PlatformSettingEnum $platformSetting): ?PlatformSetting
    {
        return $this->findOneBy(['key' => $platformSetting->name]);
    }
}
