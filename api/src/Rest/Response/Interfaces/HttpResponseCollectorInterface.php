<?php

namespace App\Rest\Response\Interfaces;

interface HttpResponseCollectorInterface extends ResponseCollectorInterface
{
    public function getHttpCode(): int;

    public function setHttpCode(int $code): self;

    public function getHeaders(): array;

    public function setHeaders(array $headers): self;

    public function addHeader(string $name, string $value): self;
}