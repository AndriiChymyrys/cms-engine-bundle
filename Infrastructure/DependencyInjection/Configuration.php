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
            ->end();

        return $treeBuilder;
    }
}
