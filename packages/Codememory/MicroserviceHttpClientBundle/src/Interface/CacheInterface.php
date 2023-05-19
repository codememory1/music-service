<?php

namespace Codememory\MicroserviceHttpClientBundle\Interface;

interface CacheInterface
{
    public function setExpire(int $seconds): self;

    public function has(string $host, string $path): bool;

    public function get(string $host, string $path): array;

    public function save(string $host, string $path, array $data): bool;
}