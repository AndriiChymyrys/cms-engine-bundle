<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;

interface ThemeProviderRegistryInterface
{
    public function add(ThemeProviderInterface $themeProvider): void;

    public function has(string $themName): bool;

    public function get(string $themeName): ThemeProviderInterface;

    /**
     * @return array<string, ThemeProviderInterface>
     */
    public function all(): array;
}
