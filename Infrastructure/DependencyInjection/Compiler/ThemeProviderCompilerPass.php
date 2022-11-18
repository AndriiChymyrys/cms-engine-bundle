<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeProviderRegistry;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;

class ThemeProviderCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        $themeRegistryDefinition = $container->getDefinition(ThemeProviderRegistry::class);

        foreach ($container->findTaggedServiceIds(ThemeProviderInterface::SERVICE_NAME) as $key => $attribute) {
            $themeRegistryDefinition->addMethodCall('add', [$container->getDefinition($key)]);
        }
    }
}
