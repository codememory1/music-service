<?php

namespace Codememory\MicroserviceHttpClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('codememory_microservice_http_client');
        $rootNode = $builder->getRootNode();

        $this->addCacheAdapter($rootNode);

        return $builder;
    }

    private function addCacheAdapter(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('cache')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('adapter')
                            ->cannotBeEmpty()
                            ->isRequired()
                            ->info('Name of the microservice response cache service')
                        ->end()
                        ->integerNode('expire')
                            ->defaultValue(86400)
                            ->info('Cache lifetime after which the cache should be deleted')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}