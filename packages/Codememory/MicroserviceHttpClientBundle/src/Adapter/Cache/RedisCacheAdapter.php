<?php

namespace Codememory\MicroserviceHttpClientBundle\Adapter\Cache;

use Codememory\MicroserviceHttpClientBundle\Interface\CacheInterface;
use Predis\Client;

final class RedisCacheAdapter implements CacheInterface
{
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

    public function get(string $host, string $path): array
    {
        return json_decode($this->client->get($this->key($host, $path)), true);
    }

    public function save(string $host, string $path, array $data): bool
    {
        if ($this->has($host, $path)) {
            return false;
        }

        $this->client->set($this->key($host, $path), json_encode($data), expireTTL: $this->expire);

        return true;
    }

    private function key(string $host, string $path): string
    {
        $hash = hash('sha256', rtrim($host, '/').'/'.trim($path, '/'));

        return "codememory:http:cache:$hash";
    }
}