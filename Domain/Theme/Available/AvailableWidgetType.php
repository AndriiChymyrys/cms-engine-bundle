<?php

declare(strict_types=1);

namespace WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\Available;

use WideMorph\Cms\Bundle\CmsEngineBundle\Domain\Theme\ThemeProviderRegistryInterface;

class AvailableWidgetType implements AvailableTypeInterface
{
    public function __construct(protected ThemeProviderRegistryInterface $providerRegistry)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getAvailable(): array
    {
        $availableWidgets = [];

        foreach ($this->providerRegistry->all() as $themeProvider) {
            foreach ($themeProvider->getWidgets() as $widget) {
                if (!isset($availableWidgets[$themeProvider->getName()])) {
                    $availableWidgets[$themeProvider->getName()] = [];
                }

                $availableWidgets[$themeProvider->getName()][$widget->getType()] = $widget->getName();
            }
        }

        return $availableWidgets;
    }
}
