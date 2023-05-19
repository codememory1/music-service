<?php

namespace Codememory\MicroserviceHttpClientBundle;

use Codememory\MicroserviceHttpClientBundle\DependencyInjection\MicroserviceHttpClientExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MicroserviceHttpClientBundle extends Bundle
{
    public const DEFAULT_CACHE_SERVICE_ID = 'codememory.microservice_http_client.default_cache_adapter';

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MicroserviceHttpClientExtension();
    }
}