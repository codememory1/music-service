<?php

namespace Codememory\MicroserviceHttpClientBundle\DependencyInjection\CompilerPass;

use Codememory\MicroserviceHttpClientBundle\DependencyInjection\Configuration;
use Codememory\MicroserviceHttpClientBundle\Exceptions\MissingTagKeyException;
use Codememory\MicroserviceHttpClientBundle\MicroserviceHttpClientBundle;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class RegisterAdapterHttpClientPass implements CompilerPassInterface
{
    /**
     * @throws MissingTagKeyException
     */
    public function process(ContainerBuilder $container): void
    {
        $config = $this->getConfig($container);

        $this->registerCacheAdapter($config['cache'], $container);

        $adapters = $container->findTaggedServiceIds(MicroserviceHttpClientBundle::HTTP_CLIENT_ADAPTER_TAG);

        foreach ($adapters as $id => $tags) {
            if (!array_key_exists('host', $tags[0]) || !array_key_exists('cache', $tags[0])) {
                throw new MissingTagKeyException($id, MicroserviceHttpClientBundle::HTTP_CLIENT_ADAPTER_TAG, ['host', 'cache']);
            }

            $container
                ->getDefinition($id)
                ->setArguments([
                    '$cache' => new Reference($config['cache']['adapter']),
                    '$client' => new Reference(HttpClientInterface::class),
                    '$host' => $tags[0]['host'],
                    '$useCaching' => $tags[0]['cache'],
                ]);
        }
    }

    private function registerCacheAdapter(array $config, ContainerBuilder $container): void
    {
        $adapter = $config['adapter'];
        $expire = $config['expire'];

        if ($container->hasDefinition($adapter)) {
            $container
                ->getDefinition($adapter)
                ->addMethodCall('setExpire', [
                    '$seconds' => $expire
                ]);
        } else {
            $container
                ->register($adapter)
                ->setAutowired(true)
                ->addMethodCall('setExpire', [
                    '$seconds' => $expire
                ]);
        }
    }

    private function getConfig(ContainerBuilder $container): array
    {
        $processor = new Processor();

        return $processor->processConfiguration(new Configuration(), $container->getExtensionConfig('codememory_microservice_http_client'));
    }
}