<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Exception\ThemeProviderException;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\ThemeProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\FieldProviderInterface;
use WideMorph\Cms\Bundle\CmsEngineBundle\Interaction\Contract\LayoutProviderInterface;

class ThemeManagerService implements ThemeManagerServiceInterface
{
    public function __construct(
        protected ThemeProviderRegistryInterface $providerRegistry
    ) {
    }

    public function getThemeProviderByLayout(string $layoutName): ThemeProviderInterface
    {
        foreach ($this->providerRegistry->all() as $themeProvider) {
            foreach ($themeProvider->getLayouts() as $layout) {
                if ($layoutName === $layout->getTemplatePath()) {
                    return $themeProvider;
                }
            }
        }

        throw new ThemeProviderException(
            sprintf('Theme provider not found by layout name "%s"', $layoutName)
        );
    }

    public function getThemeProviderByName(string $themeName): ThemeProviderInterface
    {
        return $this->providerRegistry->get($themeName);
    }

    public function getThemeLayoutProvider(
        ThemeProviderInterface $themeProvider,
        string $layoutName
    ): LayoutProviderInterface {
        foreach ($themeProvider->getLayouts() as $layout) {
            if ($layoutName === $layout->getTemplatePath()) {
                return $layout;
            }
        }

        throw new ThemeProviderException(
            sprintf('Layout "%s" not found in theme "%s"', $layoutName, $themeProvider->getName())
        );
    }

    public function getAllLayouts(bool $groupByTheme = true): array
    {
        $layouts = [];

        foreach ($this->providerRegistry->all() as $themeProvider) {
            $tmp = [];
            foreach ($themeProvider->getLayouts() as $layout) {
                $templatePath = $layout->getTemplatePath();
                $tmp[$templatePath] = $templatePath;
            }

            $layouts[$themeProvider->getName()] = $tmp;
        }

        return $groupByTheme ? $layouts : array_merge(...array_values($layouts));
    }

    public function getThemeFieldProvider(string $themeName, string $fieldType): FieldProviderInterface
    {
        $theme = $this->getThemeProviderByName($themeName);

        foreach ($theme->getFields() as $field) {
            if ($field->getType() === $fieldType) {
                return $field;
            }
        }

        throw new ThemeProviderException(
            sprintf('Can not find field "%s" in theme "%s"', $fieldType, $themeName)
        );
    }
}
