<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

interface ThemeManagerServiceInterface
{
    public function getAllLayouts(bool $groupByTheme = true): array;

    public function getThemeProviderByLayout(string $layoutName): ThemeProviderInterface;

    public function getThemeLayoutProvider(
        ThemeProviderInterface $themeProvider,
        string $layoutName
    ): LayoutProviderInterface;

    public function getThemeProviderByName(string $themeName): ThemeProviderInterface;
}
