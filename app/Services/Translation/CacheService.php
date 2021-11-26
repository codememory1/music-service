<?php

namespace App\Services\Translation;

use App\Services\AbstractApiService;
use Codememory\Components\Caching\Interfaces\CacheInterface;

/**
 * Class CacheService
 *
 * @package App\Services\Translation
 *
 * @author  Danil
 */
class CacheService extends AbstractApiService
{

    public const TYPE_CACHE = 'translation';
    public const NAME_CACHE = '_database-data';

    /**
     * @param array $data
     */
    public function update(array $data): void
    {

        /** @var CacheInterface $cache */
        $cache = $this->get('cache');

        $cache->create(self::TYPE_CACHE, self::NAME_CACHE, $data);

    }

    /**
     * @return array
     */
    public function getAll(): array
    {

        /** @var CacheInterface $cache */
        $cache = $this->get('cache');

        return $cache->get(self::TYPE_CACHE, self::NAME_CACHE) ?: [];

    }

}