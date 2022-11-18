<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\MorphConfigInteractionInterface;

/**
 * Class MorphExternalConfigPass
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\DependencyInjection\Compiler
 */
class MorphExternalConfigCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritDoc}
     */
    public function process(ContainerBuilder $container)
    {
        if ($container->hasDefinition(MorphConfigInteractionInterface::EXTERNAL_BUNDLE_CONFIG_SERVICE_NAME)) {
            $definition = $container->getDefinition(
                MorphConfigInteractionInterface::EXTERNAL_BUNDLE_CONFIG_SERVICE_NAME
            );
            $definition->addMethodCall(
                'set',
                [
                    'WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms',
                    [MorphConfigInteractionInterface::DB_PREFIX_SETTING_NAME => 'cms']
                ]
            );
            $definition->addMethodCall(
                'set',
                [
                    'WideMorph\Cms\Bundle\CmsEngineBundle\Infrastructure\Entity\Cms\FieldType',
                    [MorphConfigInteractionInterface::DB_PREFIX_SETTING_NAME => 'cms_field']
                ]
            );
        }
    }
}
