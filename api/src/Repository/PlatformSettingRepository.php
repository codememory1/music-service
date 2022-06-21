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
    /**
     * @inheritDoc
     */
    protected ?string $entity = PlatformSetting::class;

    /**
     * @inheritDoc
     */
    protected ?string $alias = 'ps';

    /**
     * @param string $key
     *
     * @return null|PlatformSetting
     */
    public function getSetting(string $key): ?PlatformSetting
    {
        return $this->findOneBy(['key' => $key]);
    }
}
