<?php

namespace Codememory\MicroserviceHttpClientBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class MicroserviceHttpClientExtension extends Extension
{
    public function getAlias(): string
    {
        return 'codememory';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        // TODO: Implement load() method.
    }
}