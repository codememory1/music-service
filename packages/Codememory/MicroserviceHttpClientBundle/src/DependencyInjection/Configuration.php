<?php

namespace Codememory\MicroserviceHttpClientBundle\DependencyInjection;

use Codememory\MicroserviceHttpClientBundle\MicroserviceHttpClientBundle;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('microservice_http_client');
        $rootNode = $builder->getRootNode();

        $this->addCacheAdapter($rootNode);

        return $builder;
    }

    private function addCacheAdapter(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->scalarNode('cache')
                    ->cannotBeEmpty()
                    ->defaultValue(MicroserviceHttpClientBundle::DEFAULT_CACHE_SERVICE_ID)
                    ->info('Name of the microservice response cache service')
                ->end()
            ->end();
    }
}