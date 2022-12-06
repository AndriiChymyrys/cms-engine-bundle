<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Routing\RouteProvider;
use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\TemplatePathResolver;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\PackageProviderInterface;

/**
 * Class CmsEngineExtension
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection
 */
class CmsEngineExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../Resources/config')
        );

        foreach (['domain.xml', 'presentation.xml', 'interaction.xml', 'infrastructure.xml'] as $config) {
            $loader->load($config);
        }

        $this->registerAutoconfigure($container);
        $this->handleConfigs($configs, $container);
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        if (array_key_exists('doctrine_migrations', $container->getExtensions())) {
            $container->prependExtensionConfig(
                'doctrine_migrations',
                [
                    'migrations' => [
                        'WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DoctrineMigrations\Version20221116082852',
                    ],
                ],
            );
        }
    }

    /**
     * @param ContainerBuilder $container
     *
     * @return void
     */
    protected function registerAutoconfigure(ContainerBuilder $container): void
    {
        $container->registerForAutoconfiguration(ThemeProviderInterface::class)
            ->addTag(ThemeProviderInterface::SERVICE_NAME);

        $container->registerForAutoconfiguration(PackageProviderInterface::class)
            ->addTag(PackageProviderInterface::SERVICE_NAME);
    }

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     *
     * @return void
     */
    protected function handleConfigs(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $routeProviderDefinition = $container->getDefinition(RouteProvider::class);
        $routeProviderDefinition->replaceArgument('$frontController', $config['front_controller']);

        $paths = $config['theme']['publish'];
        $templatePathResolverDefinition = $container->getDefinition(TemplatePathResolver::class);
        $templatePathResolverDefinition->replaceArgument('$templatePath', $paths['templates_path']);
        $templatePathResolverDefinition->replaceArgument('$contentTemplatesPath', $paths['content_templates_path']);
        $templatePathResolverDefinition->replaceArgument('$layoutsPath', $paths['layouts_path']);
    }
}
