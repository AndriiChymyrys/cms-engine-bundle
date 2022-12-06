<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract;

abstract class AbstractThemeProvider implements ThemeProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function getLayouts(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getFields(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getWidgets(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     */
    public function getContentTemplatesPath(): ?string
    {
        return null;
    }
}
