<?php

namespace Codememory\MicroserviceHttpClientBundle;

use Codememory\MicroserviceHttpClientBundle\DependencyInjection\CompilerPass\RegisterAdapterHttpClientPass;
use Codememory\MicroserviceHttpClientBundle\DependencyInjection\MicroserviceHttpClientExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class MicroserviceHttpClientBundle extends Bundle
{
    public const HTTP_CLIENT_ADAPTER_TAG = 'codememory.microservice_http_client.adapter';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new RegisterAdapterHttpClientPass());
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new MicroserviceHttpClientExtension();
    }
}