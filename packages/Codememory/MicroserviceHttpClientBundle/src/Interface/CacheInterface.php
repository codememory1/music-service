<?php

namespace Codememory\MicroserviceHttpClientBundle\Interface;

interface CacheInterface
{
    public function setExpire(int $seconds): self;

    public function has(string $host, string $path): bool;

    public function get(string $host, string $path): string;

    public function save(string $host, string $path, array $data): bool;

    public function delete(string $host, string $path): void;

    public function deleteAll(): void;
}