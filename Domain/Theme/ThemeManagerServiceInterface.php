<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\WidgetProviderInterface;

interface ThemeManagerServiceInterface
{
    /**
     * @param bool $groupByTheme
     *
     * @return array
     */
    public function getAllLayouts(bool $groupByTheme = true): array;

    /**
     * @param string $layoutName
     *
     * @return ThemeProviderInterface
     */
    public function getThemeProviderByLayout(string $layoutName): ThemeProviderInterface;

    /**
     * @param ThemeProviderInterface $themeProvider
     * @param string $layoutName
     *
     * @return LayoutProviderInterface
     */
    public function getThemeLayoutProvider(
        ThemeProviderInterface $themeProvider,
        string $layoutName
    ): LayoutProviderInterface;

    /**
     * @param string $themeName
     *
     * @return ThemeProviderInterface
     */
    public function getThemeProviderByName(string $themeName): ThemeProviderInterface;

    /**
     * @param string $themeName
     * @param string $fieldType
     *
     * @return FieldProviderInterface
     */
    public function getThemeFieldProvider(string $themeName, string $fieldType): FieldProviderInterface;

    /**
     * @param string $themeName
     * @param string $widgetType
     *
     * @return WidgetProviderInterface
     */
    public function getThemeWidgetProvider(string $themeName, string $widgetType): WidgetProviderInterface;
}
