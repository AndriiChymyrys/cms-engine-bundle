<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\CmsEngineExtension;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler\TwigCompilePass;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler\SideBarLinkCompilerPass;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler\ThemeProviderCompilerPass;
use WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler\MorphExternalConfigCompilerPass;

class CmsEngineBundle extends Bundle
{
    /**
     * {@inheritDoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SideBarLinkCompilerPass());
        $container->addCompilerPass(new ThemeProviderCompilerPass());
        $container->addCompilerPass(new MorphExternalConfigCompilerPass());
        $container->addCompilerPass(new TwigCompilePass());
    }

    /**
     * {@inheritDoc}
     */
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new CmsEngineExtension();
    }
}
