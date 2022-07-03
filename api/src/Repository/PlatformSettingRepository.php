<?php

namespace App\Repository;

use App\Entity\PlatformSetting;

/**
 * Class PlatformSettingRepository.
 *
 * @package App\Repository
 * @template-extends AbstractRepository<PlatformSetting>
 *
 * @author  Codememory
 */
class PlatformSettingRepository extends AbstractRepository
{
    protected ?string $entity = PlatformSetting::class;
    protected ?string $alias = 'ps';

    public function getSetting(string $key): ?PlatformSetting
    {
        return $this->findOneBy(['key' => $key]);
    }
}
