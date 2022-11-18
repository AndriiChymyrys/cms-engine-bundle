<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphViewInteractionInterface;

/**
 * Class SideBarLinkCompilerPass
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler
 */
class SideBarLinkCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition(MorphViewInteractionInterface::SIDE_BAR_LINK_SERVICE_NAME)) {
            $sideBarLink = $container->getDefinition(MorphViewInteractionInterface::SIDE_BAR_LINK_SERVICE_NAME);

            $sideBarLink->addMethodCall('addLink', ['CMS', 'CMS', 100, true]);
            $sideBarLink->addMethodCall('addLink', ['cms_backoffice_view_page', 'Pages', 1, false, 'CMS']);
        }
    }
}