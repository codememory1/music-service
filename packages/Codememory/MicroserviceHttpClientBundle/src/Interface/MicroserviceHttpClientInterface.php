<?php

namespace Codememory\MicroserviceHttpClientBundle\Interface;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface MicroserviceHttpClientInterface
{
    public function request(string $path, string $method, array $options = []): self;

    public function getResponse(): ?ResponseInterface;

    public function getResponseContent(): array;

    public function getResponseData(): array;
}