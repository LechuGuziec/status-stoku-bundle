<?php

namespace LechuGuziec\StatusStokuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('status_stoku');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('widget_route')
                    ->defaultValue('/status-stoku')
                ->end()
                ->scalarNode('api_route')
                    ->defaultValue('/api/status-stoku.json')
                ->end()
                ->scalarNode('widget_template')
                    ->defaultValue('@StatusStoku/widget.html.twig')
                ->end()
                ->scalarNode('camera_url')
                    ->defaultNull()
                ->end()
                ->integerNode('cache_ttl')
                    ->defaultValue(60)
                    ->min(0)
                ->end()
                ->scalarNode('easyadmin_menu_label')
                    ->defaultValue('Status stoku')
                ->end()
                ->scalarNode('easyadmin_menu_icon')
                    ->defaultValue('fa fa-mountain')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
