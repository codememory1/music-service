<?php

namespace Codememory\MicroserviceHttpClientBundle\Event;

use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

final class HttpExceptionEvent
{
    public const NAME = 'codememory.microservice_http_client.http_exception';

    public function __construct(
        public readonly string $host,
        public readonly string $path,
        public readonly HttpExceptionInterface $exception
    ) {
    }
}