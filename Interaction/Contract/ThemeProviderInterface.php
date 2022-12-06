<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract;

/**
 * Class ThemeProviderInterface
 *
 * @package WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract
 */
interface ThemeProviderInterface
{
    /** @var string */
    public const SERVICE_NAME = 'cms.theme.provider';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array<LayoutProviderInterface>
     */
    public function getLayouts(): array;

    /**
     * @return array<FieldProviderInterface>
     */
    public function getFields(): array;

    /**
     * @return array<WidgetProviderInterface>
     */
    public function getWidgets(): array;

    /**
     * @return string|null
     */
    public function getContentTemplatesPath(): ?string;
}
