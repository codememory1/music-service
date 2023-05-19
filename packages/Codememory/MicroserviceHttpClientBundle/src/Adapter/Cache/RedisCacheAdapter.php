<?php

namespace Codememory\MicroserviceHttpClientBundle\Adapter\Cache;

use Codememory\MicroserviceHttpClientBundle\Interface\CacheInterface;
use Predis\Client;

final class RedisCacheAdapter implements CacheInterface
{
    private const CACHE_KEY = 'codememory:http:cache:*';

    private ?int $expire = null;

    public function __construct(
        private readonly Client $client
    ) {
    }

    public function setExpire(int $seconds): CacheInterface
    {
        $this->expire = $seconds;

        return $this;
    }

    public function has(string $host, string $path): bool
    {
        return (bool) $this->client->exists($this->key($host, $path));
    }

    public function get(string $host, string $path): string
    {
        return $this->client->get($this->key($host, $path));
    }

    public function save(string $host, string $path, array $data): bool
    {
        if ($this->has($host, $path)) {
            return false;
        }

        $this->client->set($this->key($host, $path), json_encode($data), 'EX', $this->expire);

        return true;
    }

    public function delete(string $host, string $path): void
    {
        if ($this->has($host, $path)) {
            $this->client->del($this->key($host, $path));
        }
    }

    public function deleteAll(): void
    {
        $this->client->del($this->client->keys(self::CACHE_KEY));
    }

    private function key(string $host, string $path): string
    {
        return str_replace('*', hash('sha256', rtrim($host, '/').'/'.trim($path, '/')), self::CACHE_KEY);
    }
}