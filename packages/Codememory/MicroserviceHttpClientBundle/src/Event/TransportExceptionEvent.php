<?php

namespace Codememory\MicroserviceHttpClientBundle\Event;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

final class TransportExceptionEvent
{
    public const NAME = 'codememory.microservice_http_client.transport_exception';

    public function __construct(
        public readonly string $host,
        public readonly string $path,
        public readonly TransportExceptionInterface $exception
    ) {
    }
}