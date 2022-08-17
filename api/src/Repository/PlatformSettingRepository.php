<?php

namespace App\Repository;

use App\Entity\PlatformSetting;

/**
 * @template-extends AbstractRepository<PlatformSetting>
 */
final class PlatformSettingRepository extends AbstractRepository
{
    protected ?string $entity = PlatformSetting::class;
    protected ?string $alias = 'ps';

    public function getSetting(string $key): ?PlatformSetting
    {
        return $this->findOneBy(['key' => $key]);
    }
}
