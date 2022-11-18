<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Render\Content\ContentRender;

/**
 * Class TwigCompilePass
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler
 */
class TwigCompilePass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     *
     * @return void
     */
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('twig')
            ->addMethodCall('addGlobal', ['content_render', new Reference(ContentRender::class)]);
    }
}
