<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\ThemeNotFoundException;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;

class ThemeProviderRegistry implements ThemeProviderRegistryInterface
{
    protected array $themes;

    public function add(ThemeProviderInterface $themeProvider): void
    {
        $this->themes[$themeProvider->getName()] = $themeProvider;
    }

    public function has(string $themName): bool
    {
        return isset($this->themes[$themName]);
    }

    public function get(string $themeName): ThemeProviderInterface
    {
        if (!$this->has($themeName)) {
            throw new ThemeNotFoundException();
        }

        return $this->themes[$themeName];
    }

    /**
     * {@inheritDoc}
     */
    public function all(): array
    {
        return $this->themes;
    }
}
