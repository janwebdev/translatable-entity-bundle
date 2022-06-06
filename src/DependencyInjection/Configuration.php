<?php

namespace Janwebdev\TranslatableEntityBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('translatable_entity');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('classes')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
