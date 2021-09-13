<?php
declare(strict_types=1);

namespace RZ\Roadiz\RozierBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder('roadiz_rozier');
        $builder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('entries')
                    ->defaultValue([])
                    ->info('Rozier backoffice default menu entries.')
                    ->prototype('array')
                    ->children()
                        ->scalarNode('name')->isRequired()->end()
                        ->scalarNode('route')->defaultNull()->end()
                        ->scalarNode('path')->defaultNull()->end()
                        ->scalarNode('icon')->isRequired()->end()
                        ->arrayNode('roles')
                            ->prototype('scalar')
                            ->defaultNull()
                            ->end()
                        ->end() // roles
                        ->arrayNode('subentries')
                            ->defaultValue([])
                            ->prototype('array')
                            ->children()
                                ->scalarNode('name')->isRequired()->end()
                                ->scalarNode('route')->defaultNull()->end()
                                ->scalarNode('path')->defaultNull()->end()
                                ->scalarNode('icon')->isRequired()->end()
                                ->arrayNode('roles')
                                    ->prototype('scalar')
                                    ->defaultNull()
                                    ->end()
                                ->end() // roles
                            ->end()
                            ->end()
                        ->end() // subentries
                    ->end()
                    ->end()
                ->end() // entries
            ->end()
        ;
        return $builder;
    }
}
