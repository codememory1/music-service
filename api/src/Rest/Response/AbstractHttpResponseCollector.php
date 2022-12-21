<?php

namespace App\Rest\Response;

use App\Rest\Response\Interfaces\HttpResponseCollectorInterface;
use LogicException;

abstract class AbstractHttpResponseCollector extends AbstractResponseCollector implements HttpResponseCollectorInterface
{
    private ?int $httpCode = null;
    private array $headers = [];

    public function getHttpCode(): int
    {
        if (null === $this->httpCode) {
            throw new LogicException(sprintf('HTTP code not specified for response scheme %s', static::class));
        }

        return $this->httpCode;
    }

    public function setHttpCode(int $code): HttpResponseCollectorInterface
    {
        $this->httpCode = $code;

        return $this;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function setHeaders(array $headers): HttpResponseCollectorInterface
    {
        $this->headers = $headers;

        return $this;
    }

    public function addHeader(string $name, string $value): HttpResponseCollectorInterface
    {
        if (!array_key_exists($name, $this->headers)) {
            $this->headers[$name] = $value;
        }

        return $this;
    }
}