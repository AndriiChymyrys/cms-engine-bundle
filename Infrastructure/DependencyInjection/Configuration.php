<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('cms_engine');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('front_controller')
                    ->defaultValue('WideMorph\Cms\Bundle\CmsEngineBundle\Presentation\Controller\Front\IndexController::index')
                    ->info('Controller to render front cms page')
                ->end()
                ->arrayNode('theme')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('publish')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('templates_path')
                                    ->defaultValue('themes')
                                    ->info('Path where to store theme templates related to /templates folder')
                                ->end()
                                ->scalarNode('content_templates_path')
                                    ->defaultValue('content_templates')
                                    ->info('Path where to store content templates from theme related to templates_path setting')
                                ->end()
                                ->scalarNode('layouts_path')
                                    ->defaultValue('layouts')
                                    ->info('Path where to store Layouts from theme related to templates_path setting')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
