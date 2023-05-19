<?php

namespace Codememory\MicroserviceHttpClientBundle\DependencyInjection;

use Codememory\MicroserviceHttpClientBundle\EventListener\CacheClear\HttpCacheClearEventListener;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class MicroserviceHttpClientExtension extends Extension
{
    public function getAlias(): string
    {
        return 'codememory_microservice_http_client';
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $this->registerHttpCacheClearEventListener($config['cache']['adapter'], $container);
    }

    private function registerHttpCacheClearEventListener(string $cacheAdapter, ContainerBuilder $container): void
    {
        $container
            ->register(HttpCacheClearEventListener::class, HttpCacheClearEventListener::class)
            ->setArguments([
                '$cache' => new Reference($cacheAdapter)
            ])
            ->addTag('kernel.event_listener', [
                'event' => 'console.command',
                'method' => 'onConsoleCommand'
            ]);
    }
}